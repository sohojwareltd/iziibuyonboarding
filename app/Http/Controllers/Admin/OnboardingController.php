<?php

namespace App\Http\Controllers\Admin;

use App\Facades\KycFieldData;
use App\Http\Controllers\Controller;
use App\Mail\KycLinkMail;
use App\Models\AcquirerMaster;
use App\Models\Country;
use App\Models\KycSection;
use App\Models\Onboarding;
use App\Models\Partner;
use App\Models\PaymentMethodMaster;
use App\Models\PriceListMaster;
use App\Models\Role;
use App\Models\SolutionMaster;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use ZipArchive;

class OnboardingController extends Controller
{
    public function index(): View
    {
        $onboardings = Onboarding::with(['solution', 'partner', 'priceList'])
            ->latest()
            ->paginate(10);

        return view('admin.onboarding.index', compact('onboardings'));
    }

    public function create(): View
    {
        $solutions = SolutionMaster::with(['category', 'countries', 'paymentMethodMasters', 'acquirerMasters'])
            ->orderBy('name')->get();
        $partners = Partner::orderBy('title')->get();
        $paymentMethods = PaymentMethodMaster::with(['countries:id,name,code'])
            ->where('is_active', true)
            ->orderBy('display_label')
            ->get();
        $acquirers = AcquirerMaster::where('is_active', true)
            ->orderBy('name')
            ->get();
        $priceLists = PriceListMaster::query()
            ->where('status', 'active')
            ->orderBy('name')
            ->get();
        $countries = Country::orderBy('name')->get();

        return view('admin.onboarding.start', compact(
            'solutions',
            'partners',
            'paymentMethods',
            'acquirers',
            'priceLists',
            'countries'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'solution_id' => ['required', 'exists:solution_masters,id'],
            'partner_id' => ['nullable', 'exists:partners,id'],
            'legal_business_name' => ['required', 'string', 'max:255'],
            'trading_name' => ['nullable', 'string', 'max:255'],
            'registration_number' => ['nullable', 'string', 'max:255'],
            'business_website' => ['nullable', 'string', 'max:255'],
            'merchant_contact_email' => ['required', 'email', 'max:255', 'unique:onboardings,merchant_contact_email'],
            'merchant_phone_number' => ['nullable', 'string', 'max:255'],
            'country_of_operation' => ['required', 'string', 'max:10'],
            'payment_methods' => ['nullable', 'array'],
            'payment_methods.*' => ['string', 'max:255'],
            'acquirers' => ['nullable', 'array'],
            'acquirers.*' => ['string', 'max:255'],
            'price_list_id' => ['nullable', 'exists:price_list_masters,id'],
            'custom_pricing' => ['nullable', 'array'],
            'internal_tags' => ['nullable', 'array'],
            'internal_tags.*' => ['string', 'max:255'],
            'internal_notes' => ['nullable', 'string'],
        ]);

        $action = $request->input('action', 'draft');
        $status = $action == 'send' ? 'sent' : 'draft';
        $userId = Auth::id() ?? User::query()->value('id') ?? 1;
        $merchantUser = null;
        $merchantPassword = null;

        if ($status == 'sent') {
            ['user' => $merchantUser, 'plain_password' => $merchantPassword] = $this->resolveMerchantUser($validated);
        }

        $onboarding = Onboarding::create([
            ...$validated,
            'request_id' => Onboarding::generateRequestId(),
            'status' => $status,
            'created_by' => $userId,
            'merchant_user_id' => $merchantUser?->id,
            'sent_at' => $status == 'sent' ? now() : null,
            'kyc_link' => $status == 'sent' ? Onboarding::generateKycLink() : null,
        ]);

        // Send email if action is 'send'
        if ($action == 'send' && $onboarding->kyc_link) {
            try {
                Mail::to($onboarding->merchant_contact_email)
                    ->send(new KycLinkMail($onboarding, $merchantPassword));
                
                return redirect()
                    ->route('admin.onboarding.track', $onboarding)
                    ->with('success', 'Onboarding created and KYC link sent to ' . $onboarding->merchant_contact_email);
            } catch (\Exception $e) {
                return redirect()
                    ->route('admin.onboarding.track', $onboarding)
                    ->with('warning', 'Onboarding created but failed to send email: ' . $e->getMessage());
            }
        }

        return redirect()
            ->route('admin.onboarding.track', $onboarding)
            ->with('success', 'Onboarding created successfully.');
    }

    public function edit(Onboarding $onboarding): View
    {
        $solutions = SolutionMaster::with(['category', 'countries', 'paymentMethodMasters', 'acquirerMasters'])
            ->orderBy('name')->get();
        $partners = Partner::orderBy('title')->get();
        $paymentMethods = PaymentMethodMaster::with(['countries:id,name,code'])
            ->where('is_active', true)
            ->orderBy('display_label')
            ->get();
        $acquirers = AcquirerMaster::where('is_active', true)
            ->orderBy('name')
            ->get();
        $priceLists = PriceListMaster::query()
            ->where(function ($query) use ($onboarding) {
                $query->where('status', 'active');

                if (!empty($onboarding->price_list_id)) {
                    $query->orWhere('id', $onboarding->price_list_id);
                }
            })
            ->orderBy('name')
            ->get();
        $countries = Country::orderBy('name')->get();

        return view('admin.onboarding.start', compact(
            'onboarding',
            'solutions',
            'partners',
            'paymentMethods',
            'acquirers',
            'priceLists',
            'countries'
        ));
    }

    public function update(Request $request, Onboarding $onboarding)
    {
        $validated = $request->validate([
            'solution_id' => ['required', 'exists:solution_masters,id'],
            'partner_id' => ['nullable', 'exists:partners,id'],
            'legal_business_name' => ['required', 'string', 'max:255'],
            'trading_name' => ['nullable', 'string', 'max:255'],
            'registration_number' => ['nullable', 'string', 'max:255'],
            'business_website' => ['nullable', 'string', 'max:255'],
            'merchant_contact_email' => ['required', 'email', 'max:255', Rule::unique('onboardings', 'merchant_contact_email')->ignore($onboarding->id)],
            'merchant_phone_number' => ['nullable', 'string', 'max:255'],
            'country_of_operation' => ['required', 'string', 'max:10'],
            'payment_methods' => ['nullable', 'array'],
            'payment_methods.*' => ['string', 'max:255'],
            'acquirers' => ['nullable', 'array'],
            'acquirers.*' => ['string', 'max:255'],
            'price_list_id' => ['nullable', 'exists:price_list_masters,id'],
            'custom_pricing' => ['nullable', 'array'],
            'internal_tags' => ['nullable', 'array'],
            'internal_tags.*' => ['string', 'max:255'],
            'internal_notes' => ['nullable', 'string'],
        ]);

        $action = $request->input('action', 'draft');
        $status = $action === 'send' ? 'sent' : $onboarding->status;
        $shouldSendEmail = $action === 'send' && $onboarding->status !== 'sent';
        $merchantUser = null;
        $merchantPassword = null;

        if ($status === 'sent' || !is_null($onboarding->merchant_user_id)) {
            ['user' => $merchantUser, 'plain_password' => $merchantPassword] = $this->resolveMerchantUser($validated);
        }

        $onboarding->update([
            ...$validated,
            'status' => $status,
            'merchant_user_id' => $merchantUser?->id,
            'sent_at' => $status === 'sent' && is_null($onboarding->sent_at) ? now() : $onboarding->sent_at,
            'kyc_link' => $status === 'sent' && is_null($onboarding->kyc_link) ? Onboarding::generateKycLink() : $onboarding->kyc_link,
        ]);

        // Send email if action is 'send' and wasn't sent before
        if ($shouldSendEmail && $onboarding->kyc_link) {
            try {
                Mail::to($onboarding->merchant_contact_email)
                    ->send(new KycLinkMail($onboarding, $merchantPassword));
                
                return redirect()
                    ->route('admin.onboarding.index')
                    ->with('success', 'Onboarding updated and KYC link sent to ' . $onboarding->merchant_contact_email);
            } catch (\Exception $e) {
                return redirect()
                    ->route('admin.onboarding.index')
                    ->with('warning', 'Onboarding updated but failed to send email: ' . $e->getMessage());
            }
        }

        return redirect()
            ->route('admin.onboarding.index')
            ->with('success', 'Onboarding updated successfully.');
    }

    public function destroy(Onboarding $onboarding)
    {
        $onboarding->delete();

        return redirect()
            ->route('admin.onboarding.index')
            ->with('success', 'Onboarding deleted successfully.');
    }

    public function start(): View
    {
        return $this->create();
    }

    public function track(Onboarding $onboarding): View
    {
        $onboarding->load(['solution.category', 'partner', 'priceList', 'creator', 'approver']);
        $kycSections = $this->getOrderedKycSections();
        $kycSectionData = $this->buildKycSectionData($onboarding, $kycSections);

        // Resolve acquirer codes to AcquirerMaster records
        $acquirerRecords = collect();
        if (!empty($onboarding->acquirers)) {
            $acquirerRecords = AcquirerMaster::whereIn('name', $onboarding->acquirers)
                ->orWhereIn('id', array_filter($onboarding->acquirers, 'is_numeric'))
                ->get();
        }

        // Resolve country
        $country = Country::where('code', $onboarding->country_of_operation)
            ->orWhere('name', $onboarding->country_of_operation)
            ->first();

        // Resolve payment method codes to names
        $paymentMethodNames = collect();
        if (!empty($onboarding->payment_methods)) {
            $paymentMethodNames = PaymentMethodMaster::whereIn('name', $onboarding->payment_methods)
                ->orWhereIn('id', array_filter($onboarding->payment_methods, 'is_numeric'))
                ->pluck('display_label');
        }

        // KYC completion percentage (simple heuristic based on filled fields)
        $kycFields = ['legal_business_name', 'trading_name', 'registration_number', 'business_website',
            'merchant_contact_email', 'merchant_phone_number', 'country_of_operation',
            'payment_methods', 'acquirers'];
        $filled = collect($kycFields)->filter(fn($f) => !empty($onboarding->$f))->count();
        $kycPercent = round(($filled / count($kycFields)) * 100);

        return view('admin.onboarding.track', compact(
            'onboarding',
            'acquirerRecords',
            'country',
            'paymentMethodNames',
            'kycPercent',
            'kycSections',
            'kycSectionData'
        ));
    }

    public function exportTrack(Onboarding $onboarding, string $format)
    {
        $format = strtolower($format);

        abort_unless(in_array($format, ['zip', 'pdf', 'json'], true), 404);

        $onboarding->load(['solution.category', 'partner', 'priceList', 'creator', 'approver']);

        $acquirerRecords = collect();
        if (!empty($onboarding->acquirers)) {
            $acquirerRecords = AcquirerMaster::whereIn('name', $onboarding->acquirers)
                ->orWhereIn('id', array_filter($onboarding->acquirers, 'is_numeric'))
                ->get();
        }

        $country = Country::where('code', $onboarding->country_of_operation)
            ->orWhere('name', $onboarding->country_of_operation)
            ->first();

        $paymentMethodNames = collect();
        if (!empty($onboarding->payment_methods)) {
            $paymentMethodNames = PaymentMethodMaster::whereIn('name', $onboarding->payment_methods)
                ->orWhereIn('id', array_filter($onboarding->payment_methods, 'is_numeric'))
                ->pluck('display_label');
        }

        $kycSections = $this->getOrderedKycSections();
        $kycSectionData = $this->buildKycSectionData($onboarding, $kycSections);
        $payload = $this->buildKycExportPayload($onboarding, $kycSections, $kycSectionData, $country, $paymentMethodNames, $acquirerRecords);
        $safeRequestId = Str::slug($onboarding->request_id ?: ('onboarding-' . $onboarding->id));

        if ($format === 'json') {
            return response()->streamDownload(function () use ($payload) {
                echo json_encode($payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
            }, $safeRequestId . '-kyc-payload.json', [
                'Content-Type' => 'application/json',
            ]);
        }

        if ($format === 'pdf') {
            $pdf = Pdf::loadView('admin.onboarding.exports.summary-pdf', [
                'payload' => $payload,
            ])->setPaper('a4');

            return $pdf->download($safeRequestId . '-summary.pdf');
        }

        $zipPath = tempnam(sys_get_temp_dir(), 'kyczip_');
        $zip = new ZipArchive();
        $zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE);

        $zip->addFromString('payload.json', json_encode($payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
        $pdfBinary = Pdf::loadView('admin.onboarding.exports.summary-pdf', [
            'payload' => $payload,
        ])->setPaper('a4')->output();
        $zip->addFromString('summary.pdf', $pdfBinary);

        foreach ($payload['kyc_sections'] as $section) {
            foreach ($section['entries'] as $entry) {
                foreach ($entry['fields'] as $field) {
                    $filePath = $field['file_path'] ?? null;

                    if (!is_string($filePath) || $filePath === '' || !Storage::disk('public')->exists($filePath)) {
                        continue;
                    }

                    $zipEntryPath = 'files/' . $section['slug'] . '/';
                    if (isset($entry['group_index']) && $entry['group_index'] !== null) {
                        $zipEntryPath .= 'entry-' . ((int) $entry['group_index'] + 1) . '/';
                    }
                    $zipEntryPath .= basename($filePath);

                    $zip->addFile(storage_path('app/public/' . $filePath), $zipEntryPath);
                }
            }
        }

        $zip->close();

        return response()->download($zipPath, $safeRequestId . '-full-package.zip')->deleteFileAfterSend(true);
    }

    private function resolveMerchantUser(array $validated): array
    {
        $merchantRole = Role::firstOrCreate(
            ['name' => 'Merchant'],
            ['description' => 'Merchant user']
        );
        $merchantPassword = Str::password(length: 20, letters: true, numbers: true, symbols: true, spaces: false);
        $merchantUser = User::firstOrCreate(
            ['email' => $validated['merchant_contact_email']],
            [
                'name' => $validated['legal_business_name'],
                'role_id' => $merchantRole->id,
                'password' => Hash::make($merchantPassword),
            ]
        );

        return [
            'user' => $merchantUser,
            'plain_password' => $merchantUser->wasRecentlyCreated ? $merchantPassword : null,
        ];
    }

    private function getOrderedKycSections()
    {
        return KycSection::query()
            ->where('status', 'active')
            ->with(['kycFields' => function ($query) {
                $query->where('status', 'active')
                    ->orderBy('sort_order')
                    ->orderBy('id');
            }])
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();
    }

    private function buildKycSectionData(Onboarding $onboarding, $kycSections): array
    {
        $groupedSectionSlugs = ['beneficial-owners', 'board-members-gm', 'authorized-signatories'];
        $kycSectionData = [];

        foreach ($kycSections as $section) {
            $isGrouped = in_array($section->slug, $groupedSectionSlugs, true);

            $kycSectionData[$section->id] = [
                'type' => $isGrouped ? 'grouped' : 'single',
                'values' => $isGrouped
                    ? KycFieldData::getGroupedForSection($onboarding, $section)
                    : KycFieldData::getForSection($onboarding, $section),
            ];
        }

        return $kycSectionData;
    }

    private function buildKycExportPayload(Onboarding $onboarding, $kycSections, array $kycSectionData, ?Country $country, $paymentMethodNames, $acquirerRecords): array
    {
        $sections = [];

        foreach ($kycSections as $section) {
            $sectionData = $kycSectionData[$section->id] ?? ['type' => 'single', 'values' => []];
            $isGrouped = ($sectionData['type'] ?? 'single') === 'grouped';
            $sectionValues = $sectionData['values'] ?? [];
            $entries = [];

            if ($isGrouped) {
                foreach ($sectionValues as $groupIndex => $groupValues) {
                    $entries[] = [
                        'group_index' => (int) $groupIndex,
                        'fields' => $section->kycFields->map(function ($field) use ($groupValues) {
                            return $this->buildExportFieldPayload($field, $groupValues[$field->id] ?? null);
                        })->values()->all(),
                    ];
                }
            } else {
                $entries[] = [
                    'group_index' => null,
                    'fields' => $section->kycFields->map(function ($field) use ($sectionValues) {
                        return $this->buildExportFieldPayload($field, $sectionValues[$field->id] ?? null);
                    })->values()->all(),
                ];
            }

            $sections[] = [
                'id' => $section->id,
                'name' => $section->name,
                'slug' => $section->slug,
                'description' => $section->description,
                'sort_order' => $section->sort_order,
                'type' => $sectionData['type'] ?? 'single',
                'entries' => $entries,
            ];
        }

        return [
            'exported_at' => now()->toIso8601String(),
            'onboarding' => [
                'id' => $onboarding->id,
                'request_id' => $onboarding->request_id,
                'status' => $onboarding->status,
                'legal_business_name' => $onboarding->legal_business_name,
                'trading_name' => $onboarding->trading_name,
                'registration_number' => $onboarding->registration_number,
                'merchant_contact_email' => $onboarding->merchant_contact_email,
                'merchant_phone_number' => $onboarding->merchant_phone_number,
                'business_website' => $onboarding->business_website,
                'country' => $country?->name ?? $onboarding->country_of_operation,
                'country_code' => $country?->code,
                'solution' => $onboarding->solution?->name,
                'partner' => $onboarding->partner?->title,
                'price_list' => $onboarding->priceList?->name,
                'payment_methods' => $paymentMethodNames->values()->all(),
                'acquirers' => $acquirerRecords->pluck('name')->values()->all(),
                'created_at' => optional($onboarding->created_at)->toIso8601String(),
                'updated_at' => optional($onboarding->updated_at)->toIso8601String(),
                'sent_at' => optional($onboarding->sent_at)->toIso8601String(),
                'approved_at' => optional($onboarding->approved_at)->toIso8601String(),
                'kyc_completed_at' => optional($onboarding->kyc_completed_at)->toIso8601String(),
            ],
            'kyc_sections' => $sections,
        ];
    }

    private function buildExportFieldPayload($field, mixed $value): array
    {
        $filePath = $field->data_type === 'file' && is_string($value) && $value !== '' ? $value : null;
        $fileUrl = $filePath ? Storage::url($filePath) : null;

        return [
            'id' => $field->id,
            'label' => $field->field_name,
            'key' => $field->internal_key,
            'type' => $field->data_type,
            'required' => (bool) $field->is_required,
            'raw_value' => $value,
            'display_value' => $this->formatExportValue($field->data_type, $value),
            'file_path' => $filePath,
            'file_url' => $fileUrl,
        ];
    }

    private function formatExportValue(string $dataType, mixed $value): mixed
    {
        if ($value === null || $value === '') {
            return '—';
        }

        return match ($dataType) {
            'checkbox', 'radio' => $value ? 'Yes' : 'No',
            'dropdown', 'multi-select', 'country' => is_array($value) ? implode(', ', $value) : $value,
            'file' => is_string($value) ? basename($value) : 'Uploaded file',
            default => is_array($value) ? implode(', ', $value) : $value,
        };
    }
}

