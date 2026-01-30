<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PriceListMaster;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PriceListMasterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $priceLists = PriceListMaster::latest()->paginate(15);

        return view('admin.masters.price-list-master', [
            'priceLists' => $priceLists,
        ]);
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
        $input = $request->all();

        if (isset($input['assignment_rules']) && is_string($input['assignment_rules'])) {
            $input['assignment_rules'] = json_decode($input['assignment_rules'], true) ?? [];
        }

        if (isset($input['price_lines']) && is_string($input['price_lines'])) {
            $input['price_lines'] = json_decode($input['price_lines'], true) ?? [];
        }

        $request->merge($input);

        $validated = $request->validate([
            'name' => 'required|string|unique:price_list_masters|max:255',
            'type' => 'required|in:merchant-selling,acquirer-cost,partner-kickback',
            'currency' => 'required|string|size:3',
            'status' => 'required|in:active,draft,inactive',
            'assignment_level' => 'required|in:global,country,solution,acquirer,merchant',
            'assignment_rules' => 'nullable|array',
            'price_lines' => 'nullable|array',
            'version' => 'nullable|string|max:10',
            'effective_from' => 'nullable|date',
            'effective_to' => 'nullable|date|after_or_equal:effective_from',
        ]);

        if (isset($validated['assignment_rules']) && is_array($validated['assignment_rules'])) {
            $validated['assignment_rules'] = json_encode($validated['assignment_rules']);
        }

        if (isset($validated['price_lines']) && is_array($validated['price_lines'])) {
            $validated['price_lines'] = json_encode($validated['price_lines']);
        }

        $priceList = PriceListMaster::create($validated);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Price list created successfully',
                'data' => $priceList,
            ], 201);
        }

        return redirect()->route('admin.masters.price-list-master')
            ->with('success', 'Price list created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $priceList = PriceListMaster::findOrFail($id);

        $priceListData = $priceList->toArray();
        if (is_string($priceListData['assignment_rules'])) {
            $priceListData['assignment_rules'] = json_decode($priceListData['assignment_rules'], true) ?? [];
        }
        if (is_string($priceListData['price_lines'])) {
            $priceListData['price_lines'] = json_decode($priceListData['price_lines'], true) ?? [];
        }

        return response()->json([
            'success' => true,
            'data' => $priceListData,
        ]);
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
        $priceList = PriceListMaster::findOrFail($id);

        $input = $request->all();

        if (isset($input['assignment_rules']) && is_string($input['assignment_rules'])) {
            $input['assignment_rules'] = json_decode($input['assignment_rules'], true) ?? [];
        }

        if (isset($input['price_lines']) && is_string($input['price_lines'])) {
            $input['price_lines'] = json_decode($input['price_lines'], true) ?? [];
        }

        $request->merge($input);

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                Rule::unique('price_list_masters')->ignore($id),
                'max:255',
            ],
            'type' => 'required|in:merchant-selling,acquirer-cost,partner-kickback',
            'currency' => 'required|string|size:3',
            'status' => 'required|in:active,draft,inactive',
            'assignment_level' => 'required|in:global,country,solution,acquirer,merchant',
            'assignment_rules' => 'nullable|array',
            'price_lines' => 'nullable|array',
            'version' => 'nullable|string|max:10',
            'effective_from' => 'nullable|date',
            'effective_to' => 'nullable|date|after_or_equal:effective_from',
        ]);

        if (isset($validated['assignment_rules']) && is_array($validated['assignment_rules'])) {
            $validated['assignment_rules'] = json_encode($validated['assignment_rules']);
        }

        if (isset($validated['price_lines']) && is_array($validated['price_lines'])) {
            $validated['price_lines'] = json_encode($validated['price_lines']);
        }

        $priceList->update($validated);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Price list updated successfully',
                'data' => $priceList,
            ]);
        }

        return redirect()->route('admin.masters.price-list-master')
            ->with('success', 'Price list updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $priceList = PriceListMaster::findOrFail($id);
        $priceList->delete();

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Price list deleted successfully',
            ]);
        }

        return redirect()->route('admin.masters.price-list-master')
            ->with('success', 'Price list deleted successfully');
    }
}
