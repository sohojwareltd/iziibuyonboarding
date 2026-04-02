<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KycSection;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class KycSectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = KycSection::query();

        if ($search = request('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('slug', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($status = request('status')) {
            $query->where('status', $status);
        }

        $kycSections = $query->orderBy('sort_order')->paginate(15)->withQueryString();

        return view('admin.masters.kyc_section', compact('kycSections'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return redirect()->route('admin.masters.kyc-section-master');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name'           => 'required|string|max:255|unique:kyc_sections,name',
                'slug'           => 'nullable|string|max:255|unique:kyc_sections,slug',
                'description'    => 'nullable|string',
                'sort_order'     => 'required|integer|min:0',
                'status'         => 'required|in:active,inactive',
                'allow_multiple' => 'nullable|boolean',
            ]);

            $validated['allow_multiple'] = $request->boolean('allow_multiple');

            if (empty($validated['slug'])) {
                $validated['slug'] = Str::slug($validated['name']);
            }

            $kycSection = KycSection::create($validated);

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'KYC section created successfully',
                    'data' => $kycSection,
                ], 201);
            }

            return redirect()->route('admin.masters.kyc-section-master')
                ->with('success', 'KYC section created successfully');
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
    public function show(string $id)
    {
        $kycSection = KycSection::findOrFail($id);

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'data' => $kycSection,
            ]);
        }

        return redirect()->route('admin.masters.kyc-section-master');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $kycSection = KycSection::findOrFail($id);

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'data' => $kycSection,
            ]);
        }

        return redirect()->route('admin.masters.kyc-section-master');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $kycSection = KycSection::findOrFail($id);

        try {
            $validated = $request->validate([
                'name' => [
                    'required',
                    'string',
                    'max:255',
                    Rule::unique('kyc_sections', 'name')->ignore($kycSection->id),
                ],
                'slug' => [
                    'nullable',
                    'string',
                    'max:255',
                    Rule::unique('kyc_sections', 'slug')->ignore($kycSection->id),
                ],
                'description'    => 'nullable|string',
                'sort_order'     => 'required|integer|min:0',
                'status'         => 'required|in:active,inactive',
                'allow_multiple' => 'nullable|boolean',
            ]);

            $validated['allow_multiple'] = $request->boolean('allow_multiple');

            if (empty($validated['slug'])) {
                $validated['slug'] = Str::slug($validated['name']);
            }

            $kycSection->update($validated);

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'KYC section updated successfully',
                    'data' => $kycSection,
                ]);
            }

            return redirect()->route('admin.masters.kyc-section-master')
                ->with('success', 'KYC section updated successfully');
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
    public function destroy(string $id)
    {
        $kycSection = KycSection::findOrFail($id);

        try {
            $kycSection->delete();
        } catch (\Illuminate\Database\QueryException $e) {
            $message = 'Unable to delete KYC section because it is already in use.';

            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $message,
                ], 422);
            }

            return redirect()->route('admin.masters.kyc-section-master')->with('error', $message);
        }

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'KYC section deleted successfully',
            ]);
        }

        return redirect()->route('admin.masters.kyc-section-master')
            ->with('success', 'KYC section deleted successfully');
    }
}
