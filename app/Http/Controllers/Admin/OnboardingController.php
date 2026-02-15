<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\KycLinkMail;
use App\Models\AcquirerMaster;
use App\Models\Country;
use App\Models\Onboarding;
use App\Models\Partner;
use App\Models\PaymentMethodMaster;
use App\Models\PriceListMaster;
use App\Models\Role;
use App\Models\SolutionMaster;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

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
        $paymentMethods = PaymentMethodMaster::where('is_active', true)
            ->orderBy('display_label')
            ->get();
        $acquirers = AcquirerMaster::where('is_active', true)
            ->orderBy('name')
            ->get();
        $priceLists = PriceListMaster::where('status', 'active')->orderBy('name')->get();
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
        $status = $action === 'send' ? 'sent' : 'draft';
        $userId = auth()->id() ?? User::first()?->id ?? 1;
        $merchantRole = Role::firstOrCreate(
            ['name' => 'Merchant'],
            ['description' => 'Merchant user']
        );
        $merchantUser = User::firstOrCreate(
            ['email' => $validated['merchant_contact_email']],
            [
                'name' => $validated['legal_business_name'],
                'role_id' => $merchantRole->id,
                'password' => Hash::make(Str::random(16)),
            ]
        );

        $onboarding = Onboarding::create([
            ...$validated,
            'request_id' => Onboarding::generateRequestId(),
            'status' => $status,
            'created_by' => $userId,
            'merchant_user_id' => $merchantUser->id,
            'sent_at' => $status === 'sent' ? now() : null,
            'kyc_link' => $status === 'sent' ? Onboarding::generateKycLink() : null,
        ]);

        // Send email if action is 'send'
        if ($action === 'send' && $onboarding->kyc_link) {
            try {
                Mail::to($onboarding->merchant_contact_email)
                    ->send(new KycLinkMail($onboarding));
                
                return redirect()
                    ->route('admin.onboarding.index')
                    ->with('success', 'Onboarding created and KYC link sent to ' . $onboarding->merchant_contact_email);
            } catch (\Exception $e) {
                return redirect()
                    ->route('admin.onboarding.index')
                    ->with('warning', 'Onboarding created but failed to send email: ' . $e->getMessage());
            }
        }

        return redirect()
            ->route('admin.onboarding.index')
            ->with('success', 'Onboarding created successfully.');
    }

    public function edit(Onboarding $onboarding): View
    {
        $solutions = SolutionMaster::with(['category', 'countries', 'paymentMethodMasters', 'acquirerMasters'])
            ->orderBy('name')->get();
        $partners = Partner::orderBy('title')->get();
        $paymentMethods = PaymentMethodMaster::where('is_active', true)
            ->orderBy('display_label')
            ->get();
        $acquirers = AcquirerMaster::where('is_active', true)
            ->orderBy('name')
            ->get();
        $priceLists = PriceListMaster::orderBy('name')->get();
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
        $merchantRole = Role::firstOrCreate(
            ['name' => 'Merchant'],
            ['description' => 'Merchant user']
        );
        $merchantUser = User::firstOrCreate(
            ['email' => $validated['merchant_contact_email']],
            [
                'name' => $validated['legal_business_name'],
                'role_id' => $merchantRole->id,
                'password' => Hash::make(Str::random(16)),
            ]
        );

        $onboarding->update([
            ...$validated,
            'status' => $status,
            'merchant_user_id' => $merchantUser->id,
            'sent_at' => $status === 'sent' && is_null($onboarding->sent_at) ? now() : $onboarding->sent_at,
            'kyc_link' => $status === 'sent' && is_null($onboarding->kyc_link) ? Onboarding::generateKycLink() : $onboarding->kyc_link,
        ]);

        // Send email if action is 'send' and wasn't sent before
        if ($shouldSendEmail && $onboarding->kyc_link) {
            try {
                Mail::to($onboarding->merchant_contact_email)
                    ->send(new KycLinkMail($onboarding));
                
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
            'kycPercent'
        ));
    }
}

