<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AcquirerMaster;
use App\Models\SolutionMaster;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class AcquirerMasterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = AcquirerMaster::query();

        // Filter by search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%");
        }

        // Filter by mode
        if ($request->filled('mode')) {
            $query->where('mode', $request->mode);
        }

        // Filter by status
        if ($request->filled('status')) {
            $status = $request->status === 'active' ? true : false;
            $query->where('is_active', $status);
        }

        // Filter by country (JSON search)
        if ($request->filled('country')) {
            $query->whereJsonContains('supported_countries', $request->country);
        }

        $acquirers = $query->latest()->paginate(15);
        $solutions = SolutionMaster::all();
        
        // Get unique countries for filter dropdown
        $countries = AcquirerMaster::whereNotNull('supported_countries')
            ->get()
            ->pluck('supported_countries')
            ->flatten()
            ->unique()
            ->sort()
            ->values();
        
        return view('admin.masters.acquirer-master', [
            'acquirers' => $acquirers,
            'solutions' => $solutions,
            'countries' => $countries,
        ]);
    }

    /**
     * Export Acquirer Master data to Excel.
     */
    public function export(Request $request)
    {
        $query = AcquirerMaster::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('description', 'LIKE', "%{$search}%");
            });
        }

        if ($request->filled('mode')) {
            $query->where('mode', $request->mode);
        }

        if ($request->filled('status')) {
            $status = $request->status === 'active' ? true : false;
            $query->where('is_active', $status);
        }

        if ($request->filled('country')) {
            $query->whereJsonContains('supported_countries', $request->country);
        }

        $acquirers = $query->latest()->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $headers = [
            'ID',
            'Name',
            'Mode',
            'Active',
            'Description',
            'Supported Countries',
            'Supported Solutions',
            'Email Recipient',
            'Email Subject Template',
            'Email Body Template',
            'Attachment Format',
            'Secure Email Required',
            'Requires Beneficial Owner Data',
            'Requires Board Member Data',
            'Requires Signatories',
            'Created At',
            'Updated At',
        ];

        $sheet->fromArray($headers, null, 'A1');

        $row = 2;
        foreach ($acquirers as $acquirer) {
            $sheet->fromArray([
                $acquirer->id,
                $acquirer->name,
                $acquirer->mode,
                $acquirer->is_active ? 'Yes' : 'No',
                $acquirer->description,
                $this->implodeArray($acquirer->supported_countries),
                $this->implodeArray($acquirer->supported_solutions),
                $acquirer->email_recipient,
                $acquirer->email_subject_template,
                $acquirer->email_body_template,
                $acquirer->attachment_format,
                $acquirer->secure_email_required ? 'Yes' : 'No',
                $acquirer->requires_beneficial_owner_data ? 'Yes' : 'No',
                $acquirer->requires_board_member_data ? 'Yes' : 'No',
                $acquirer->requires_signatories ? 'Yes' : 'No',
                optional($acquirer->created_at)->toDateTimeString(),
                optional($acquirer->updated_at)->toDateTimeString(),
            ], null, 'A' . $row);
            $row++;
        }

        return response()->streamDownload(function () use ($spreadsheet) {
            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
        }, 'acquirer-master.xlsx', [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }

    private function implodeArray($value): string
    {
        if (is_string($value)) {
            $decoded = json_decode($value, true);
            if (is_array($decoded)) {
                return implode(', ', $decoded);
            }
            return $value;
        }

        if (is_array($value)) {
            return implode(', ', $value);
        }

        return '';
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Parse JSON fields if they come as strings BEFORE validation
        $input = $request->all();
        
        if (isset($input['supported_countries']) && is_string($input['supported_countries'])) {
            $input['supported_countries'] = json_decode($input['supported_countries'], true) ?? [];
        }
        
        if (isset($input['supported_solutions']) && is_string($input['supported_solutions'])) {
            $input['supported_solutions'] = json_decode($input['supported_solutions'], true) ?? [];
        }

        // Convert string boolean values to actual booleans
        $input['is_active'] = isset($input['is_active']) ? (bool)$input['is_active'] : false;
        $input['secure_email_required'] = isset($input['secure_email_required']) && $input['secure_email_required'] !== '0';
        $input['requires_beneficial_owner_data'] = isset($input['requires_beneficial_owner_data']) && $input['requires_beneficial_owner_data'] !== '0';
        $input['requires_board_member_data'] = isset($input['requires_board_member_data']) && $input['requires_board_member_data'] !== '0';
        $input['requires_signatories'] = isset($input['requires_signatories']) && $input['requires_signatories'] !== '0';

        // Replace request input with parsed data
        $request->merge($input);

        $validated = $request->validate([
            'name' => 'required|string|unique:acquirer_masters|max:255',
            'mode' => 'required|in:email,api',
            'is_active' => 'boolean',
            'description' => 'nullable|string',
            'supported_countries' => 'nullable|array',
            'supported_solutions' => 'nullable|array',
            'email_recipient' => 'nullable|email',
            'email_subject_template' => 'nullable|string|max:255',
            'email_body_template' => 'nullable|string',
            'attachment_format' => 'nullable|in:pdf,zip',
            'secure_email_required' => 'boolean',
            'requires_beneficial_owner_data' => 'boolean',
            'requires_board_member_data' => 'boolean',
            'requires_signatories' => 'boolean',
        ]);

        // Ensure arrays are stored as JSON
        if (isset($validated['supported_countries']) && is_array($validated['supported_countries'])) {
            $validated['supported_countries'] = json_encode($validated['supported_countries']);
        }

        if (isset($validated['supported_solutions']) && is_array($validated['supported_solutions'])) {
            $validated['supported_solutions'] = json_encode($validated['supported_solutions']);
        }

        $acquirer = AcquirerMaster::create($validated);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Acquirer created successfully',
                'data' => $acquirer,
            ], 201);
        }

        return redirect()->route('admin.masters.acquirer-master')
            ->with('success', 'Acquirer created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $acquirer = AcquirerMaster::findOrFail($id);
        
        // Ensure arrays are properly decoded
        $acquirer_data = $acquirer->toArray();
        if (is_string($acquirer_data['supported_countries'])) {
            $acquirer_data['supported_countries'] = json_decode($acquirer_data['supported_countries'], true) ?? [];
        }
        if (is_string($acquirer_data['supported_solutions'])) {
            $acquirer_data['supported_solutions'] = json_decode($acquirer_data['supported_solutions'], true) ?? [];
        }

        return response()->json([
            'success' => true,
            'data' => $acquirer_data,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $acquirer = AcquirerMaster::findOrFail($id);

        // Parse JSON fields if they come as strings BEFORE validation
        $input = $request->all();
        
        if (isset($input['supported_countries']) && is_string($input['supported_countries'])) {
            $input['supported_countries'] = json_decode($input['supported_countries'], true) ?? [];
        }
        
        if (isset($input['supported_solutions']) && is_string($input['supported_solutions'])) {
            $input['supported_solutions'] = json_decode($input['supported_solutions'], true) ?? [];
        }

        // Convert string boolean values to actual booleans
        $input['is_active'] = isset($input['is_active']) ? (bool)$input['is_active'] : false;
        $input['secure_email_required'] = isset($input['secure_email_required']) && $input['secure_email_required'] !== '0';
        $input['requires_beneficial_owner_data'] = isset($input['requires_beneficial_owner_data']) && $input['requires_beneficial_owner_data'] !== '0';
        $input['requires_board_member_data'] = isset($input['requires_board_member_data']) && $input['requires_board_member_data'] !== '0';
        $input['requires_signatories'] = isset($input['requires_signatories']) && $input['requires_signatories'] !== '0';

        // Replace request input with parsed data
        $request->merge($input);

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                Rule::unique('acquirer_masters')->ignore($acquirer->id),
                'max:255'
            ],
            'mode' => 'required|in:email,api',
            'is_active' => 'boolean',
            'description' => 'nullable|string',
            'supported_countries' => 'nullable|array',
            'supported_solutions' => 'nullable|array',
            'email_recipient' => 'nullable|email',
            'email_subject_template' => 'nullable|string|max:255',
            'email_body_template' => 'nullable|string',
            'attachment_format' => 'nullable|in:pdf,zip',
            'secure_email_required' => 'boolean',
            'requires_beneficial_owner_data' => 'boolean',
            'requires_board_member_data' => 'boolean',
            'requires_signatories' => 'boolean',
        ]);

        // Ensure arrays are stored as JSON
        if (isset($validated['supported_countries']) && is_array($validated['supported_countries'])) {
            $validated['supported_countries'] = json_encode($validated['supported_countries']);
        }

        if (isset($validated['supported_solutions']) && is_array($validated['supported_solutions'])) {
            $validated['supported_solutions'] = json_encode($validated['supported_solutions']);
        }

        $acquirer->update($validated);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Acquirer updated successfully',
                'data' => $acquirer,
            ]);
        }

        return redirect()->route('admin.masters.acquirer-master')
            ->with('success', 'Acquirer updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $acquirer = AcquirerMaster::findOrFail($id);
        $acquirer->delete();

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Acquirer deleted successfully',
            ]);
        }

        return redirect()->route('admin.masters.acquirer-master')
            ->with('success', 'Acquirer deleted successfully');
    }
}
