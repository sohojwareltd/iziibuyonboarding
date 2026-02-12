<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KYCFieldMaster;
use App\Models\KycSection;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class KYCFieldMasterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = KYCFieldMaster::with('kycSection');

        if ($search = request('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('field_name', 'like', "%{$search}%")
                    ->orWhere('internal_key', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($section = request('kyc_section')) {
            $query->where('kyc_section_id', $section);
        }

        if ($dataType = request('data_type')) {
            $query->where('data_type', $dataType);
        }

        if ($sensitivity = request('sensitivity_level')) {
            $query->where('sensitivity_level', $sensitivity);
        }

        if ($status = request('status')) {
            $query->where('status', $status);
        }

        $kycFields = $query->orderBy('sort_order')->paginate(15)->withQueryString();
        $kycSections = KycSection::active()->ordered()->get();
        return view('admin.masters.kyc-field-master', compact('kycFields', 'kycSections'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'field_name' => 'required|string|max:255|unique:k_y_c_field_masters',
                'internal_key' => 'required|string|max:255|unique:k_y_c_field_masters',
                'kyc_section_id' => 'required|exists:kyc_sections,id',
                'description' => 'nullable|string',
                'data_type' => 'required|in:text,date,number,email,tel,url,password,time,datetime-local,file,dropdown,multi-select,checkbox,radio,textarea,country,currency,address,signature',
                'is_required' => 'boolean',
                'sensitivity_level' => 'required|in:normal,sensitive,highly-sensitive',
                'visible_to_merchant' => 'boolean',
                'visible_to_admin' => 'boolean',
                'visible_to_partner' => 'boolean',
                'sort_order' => 'required|integer|min:0',
                'status' => 'required|in:active,draft,inactive',
            ]);

            KYCFieldMaster::create($validated);

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => true, 'message' => 'KYC Field created successfully']);
            }

            return redirect()->route('admin.masters.kyc-field-master')
                ->with('success', 'KYC Field created successfully');
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['errors' => $e->errors()], 422);
            }
            throw $e;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($kycField)
    {
        $kycField = KYCFieldMaster::findOrFail($kycField);
        
        if (request()->ajax()) {
            return response()->json($kycField);
        }

        return view('admin.masters.kyc-field-master', ['kycField' => $kycField]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $kycField)
    {
        $kycField = KYCFieldMaster::findOrFail($kycField);
        
        try {
            $validated = $request->validate([
                'field_name' => ['required', 'string', 'max:255', Rule::unique('k_y_c_field_masters')->ignore($kycField->id)],
                'internal_key' => ['required', 'string', 'max:255', Rule::unique('k_y_c_field_masters')->ignore($kycField->id)],
                'kyc_section_id' => 'required|exists:kyc_sections,id',
                'description' => 'nullable|string',
                'data_type' => 'required|in:text,date,number,email,tel,url,password,time,datetime-local,file,dropdown,multi-select,checkbox,radio,textarea,country,currency,address,signature',
                'is_required' => 'boolean',
                'sensitivity_level' => 'required|in:normal,sensitive,highly-sensitive',
                'visible_to_merchant' => 'boolean',
                'visible_to_admin' => 'boolean',
                'visible_to_partner' => 'boolean',
                'sort_order' => 'required|integer|min:0',
                'status' => 'required|in:active,draft,inactive',
            ]);

            $kycField->update($validated);

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => true, 'message' => 'KYC Field updated successfully']);
            }

            return redirect()->route('admin.masters.kyc-field-master')
                ->with('success', 'KYC Field updated successfully');
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['errors' => $e->errors()], 422);
            }
            throw $e;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($kycField)
    {
        $kycField = KYCFieldMaster::findOrFail($kycField);
        $kycField->delete();

        if (request()->ajax()) {
            return response()->json(['success' => true, 'message' => 'KYC Field deleted successfully']);
        }

        return redirect()->route('admin.masters.kyc-field-master')
            ->with('success', 'KYC Field deleted successfully');
    }

    /**
     * Export KYC Fields to Excel
     */
    public function export(Request $request)
    {
        $query = KYCFieldMaster::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('field_name', 'LIKE', "%{$search}%")
                    ->orWhere('internal_key', 'LIKE', "%{$search}%")
                    ->orWhere('description', 'LIKE', "%{$search}%");
            });
        }

        if ($request->filled('kyc_section')) {
            $query->where('kyc_section_id', $request->kyc_section);
        }

        if ($request->filled('data_type')) {
            $query->where('data_type', $request->data_type);
        }

        if ($request->filled('sensitivity_level')) {
            $query->where('sensitivity_level', $request->sensitivity_level);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $kycFields = $query->latest()->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('KYC Fields');

        $headers = [
            'ID',
            'Field Name',
            'Internal Key',
            'KYC Section',
            'Description',
            'Data Type',
            'Is Required',
            'Sensitivity Level',
            'Visible to Merchant',
            'Visible to Admin',
            'Visible to Partner',
            'Sort Order',
            'Status',
            'Created At',
            'Updated At'
        ];

        $sheet->fromArray($headers, null, 'A1');

        $row = 2;
        foreach ($kycFields as $kycField) {
            $sheet->fromArray([
                $kycField->id,
                $kycField->field_name,
                $kycField->internal_key,
                $kycField->kycSection->name ?? '—',
                $kycField->description,
                $kycField->data_type,
                $kycField->is_required ? 'Yes' : 'No',
                $kycField->sensitivity_level,
                $kycField->visible_to_merchant ? 'Yes' : 'No',
                $kycField->visible_to_admin ? 'Yes' : 'No',
                $kycField->visible_to_partner ? 'Yes' : 'No',
                $kycField->sort_order,
                $kycField->status,
                $kycField->created_at->format('Y-m-d H:i:s'),
                $kycField->updated_at->format('Y-m-d H:i:s')
            ], null, 'A' . $row);
            $row++;
        }

        return response()->streamDownload(function () use ($spreadsheet) {
            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
        }, 'kyc-field-master.xlsx', [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }
}
