<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DocumentTypesMaster;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DocumentTypesMasterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $documentTypes = DocumentTypesMaster::orderBy('document_name')->paginate(15);
        return view('admin.masters.document-type-master', compact('documentTypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'document_name' => 'required|string|max:255|unique:document_types_masters',
                'category' => 'required|in:identity,company,bank',
                'description' => 'nullable|string',
                'allowed_file_types' => 'required|array|min:1',
                'max_file_size' => 'required|integer|min:1',
                'min_pages' => 'nullable|integer|min:0',
                'sensitivity_level' => 'required|in:normal,sensitive,highly-sensitive',
                'visible_to_merchant' => 'boolean',
                'visible_to_admin' => 'boolean',
                'mask_metadata' => 'boolean',
                'required_acquirers' => 'nullable|array',
                'required_countries' => 'nullable|array',
                'required_solutions' => 'nullable|array',
                'kyc_section' => 'nullable|string',
                'status' => 'required|in:active,draft,inactive',
                'internal_notes' => 'nullable|string',
            ]);

            DocumentTypesMaster::create($validated);

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => true, 'message' => 'Document Type created successfully']);
            }

            return redirect()->route('admin.masters.document-type-master')
                ->with('success', 'Document Type created successfully');
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
    public function show($documentType)
    {
        $documentType = DocumentTypesMaster::findOrFail($documentType);
        
        if (request()->ajax()) {
            return response()->json($documentType);
        }

        return view('admin.masters.document-type-master', ['documentType' => $documentType]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $documentType)
    {
        $documentType = DocumentTypesMaster::findOrFail($documentType);
        
        try {
            $validated = $request->validate([
                'document_name' => ['required', 'string', 'max:255', Rule::unique('document_types_masters')->ignore($documentType->id)],
                'category' => 'required|in:identity,company,bank',
                'description' => 'nullable|string',
                'allowed_file_types' => 'required|array|min:1',
                'max_file_size' => 'required|integer|min:1',
                'min_pages' => 'nullable|integer|min:0',
                'sensitivity_level' => 'required|in:normal,sensitive,highly-sensitive',
                'visible_to_merchant' => 'boolean',
                'visible_to_admin' => 'boolean',
                'mask_metadata' => 'boolean',
                'required_acquirers' => 'nullable|array',
                'required_countries' => 'nullable|array',
                'required_solutions' => 'nullable|array',
                'kyc_section' => 'nullable|string',
                'status' => 'required|in:active,draft,inactive',
                'internal_notes' => 'nullable|string',
            ]);

            $documentType->update($validated);

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => true, 'message' => 'Document Type updated successfully']);
            }

            return redirect()->route('admin.masters.document-type-master')
                ->with('success', 'Document Type updated successfully');
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
    public function destroy($documentType)
    {
        $documentType = DocumentTypesMaster::findOrFail($documentType);
        $documentType->delete();

        if (request()->ajax()) {
            return response()->json(['success' => true, 'message' => 'Document Type deleted successfully']);
        }

        return redirect()->route('admin.masters.document-type-master')
            ->with('success', 'Document Type deleted successfully');
    }
}
