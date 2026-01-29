<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SolutionMaster;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SolutionMasterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $solutions = SolutionMaster::with('category')->get();
        $categories = Category::all();
        return view('admin.masters.solution-master', compact('solutions', 'categories'));
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
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'status' => 'nullable|in:draft,published',
            'description' => 'nullable|string',
            'country' => 'nullable|string',
            'tags' => 'nullable|array',
            'tags.*' => 'string|max:50',
            'acquirers' => 'nullable|array',
            'acquirers.*' => 'string|max:50',
            'payment_methods' => 'nullable|array',
            'payment_methods.*' => 'string|max:50',
            'alternative_methods' => 'nullable|array',
            'alternative_methods.*' => 'string|max:50',
            'requirements' => 'nullable|string',
            'pricing_plan' => 'nullable|string|max:50',
        ]);

        $slug = Str::slug($request->name);
        $status = $request->status ?? 'published';
        
        SolutionMaster::create([
            'name' => $request->name,
            'slug' => $slug,
            'category_id' => $request->category_id,
            'status' => $status,
            'description' => $request->description,
            'country' => $request->country,
            'tags' => $request->tags,
            'acquirers' => $request->acquirers,
            'payment_methods' => $request->payment_methods,
            'alternative_methods' => $request->alternative_methods,
            'requirements' => $request->requirements,
            'pricing_plan' => $request->pricing_plan,
        ]);

        return redirect()->route('admin.masters.solution-master')->with('success', 'Solution created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
        $solution = SolutionMaster::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'status' => 'nullable|in:draft,published',
            'description' => 'nullable|string',
            'country' => 'nullable|string',
            'tags' => 'nullable|array',
            'tags.*' => 'string|max:50',
            'acquirers' => 'nullable|array',
            'acquirers.*' => 'string|max:50',
            'payment_methods' => 'nullable|array',
            'payment_methods.*' => 'string|max:50',
            'alternative_methods' => 'nullable|array',
            'alternative_methods.*' => 'string|max:50',
            'requirements' => 'nullable|string',
            'pricing_plan' => 'nullable|string|max:50',
        ]);

        $slug = Str::slug($request->name);

        $solution->update([
            'name' => $request->name,
            'slug' => $slug,
            'category_id' => $request->category_id,
            'status' => $request->status ?? $solution->status,
            'description' => $request->description,
            'country' => $request->country,
            'tags' => $request->tags,
            'acquirers' => $request->acquirers,
            'payment_methods' => $request->payment_methods,
            'alternative_methods' => $request->alternative_methods,
            'requirements' => $request->requirements,
            'pricing_plan' => $request->pricing_plan,
        ]);

        return redirect()->route('admin.masters.solution-master')->with('success', 'Solution updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $solution = SolutionMaster::findOrFail($id);
        $solution->delete();

        return redirect()->route('admin.masters.solution-master')->with('success', 'Solution deleted successfully.');
    }
}
