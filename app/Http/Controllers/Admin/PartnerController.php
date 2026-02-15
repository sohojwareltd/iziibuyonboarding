<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PartnerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Partner::query();

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('referral_id', 'like', "%{$search}%")
                  ->orWhere('commission_plan', 'like', "%{$search}%");
            });
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Commission Plan filter
        if ($request->filled('commission_plan')) {
            $query->where('commission_plan', $request->commission_plan);
        }

        $partners = $query->latest()->paginate(10);

        return view('admin.partner', compact('partners'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'commission_plan' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive',
            'referral_id' => 'nullable|string|unique:partners,referral_id|max:255',
        ]);

        $validated['slug'] = Str::slug($validated['title']);

        $partner = Partner::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Partner created successfully',
            'partner' => $partner
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $partner = Partner::findOrFail($id);
        return response()->json($partner);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $partner = Partner::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'commission_plan' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive',
            'referral_id' => 'nullable|string|max:255|unique:partners,referral_id,' . $id,
        ]);

        $validated['slug'] = Str::slug($validated['title']);

        $partner->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Partner updated successfully',
            'partner' => $partner
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $partner = Partner::findOrFail($id);
        $partner->delete();

        return response()->json([
            'success' => true,
            'message' => 'Partner deleted successfully'
        ]);
    }
}
