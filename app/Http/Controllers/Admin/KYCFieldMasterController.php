<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KYCFieldMaster;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class KYCFieldMasterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kycFields = KYCFieldMaster::orderBy('sort_order')->paginate(15);
        return view('admin.masters.kyc-field-master', compact('kycFields'));
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
                'kyc_section' => 'required|in:beneficial,company,board,contact',
                'description' => 'nullable|string',
                'data_type' => 'required|in:text,date,number,email,tel,file,dropdown,textarea',
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
                'kyc_section' => 'required|in:beneficial,company,board,contact',
                'description' => 'nullable|string',
                'data_type' => 'required|in:text,date,number,email,tel,file,dropdown,textarea',
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
}
