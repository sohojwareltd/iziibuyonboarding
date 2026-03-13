<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DocumentTypeCategory;
use Illuminate\Http\Request;

class DocumentTypeCategoryController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $categories = DocumentTypeCategory::when($search, function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('slug', 'like', "%{$search}%");
            })
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        return view('admin.masters.document-type-category-master', compact('categories', 'search'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name'        => 'required|string|max:255',
                'slug'        => 'required|string|max:255|unique:document_type_categories,slug',
                'description' => 'nullable|string|max:1000',
                'is_active'   => 'boolean',
            ]);

            $validated['is_active'] = $request->boolean('is_active', true);

            $category = DocumentTypeCategory::create($validated);

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => true, 'message' => 'Category created successfully.', 'category' => $category]);
            }

            return redirect()->route('admin.masters.document-type-categories.index')
                ->with('success', 'Category created successfully.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['errors' => $e->errors()], 422);
            }
            throw $e;
        }
    }

    public function show(string $id)
    {
        $category = DocumentTypeCategory::findOrFail($id);

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json($category);
        }

        return redirect()->route('admin.masters.document-type-categories.index');
    }

    public function update(Request $request, string $id)
    {
        $category = DocumentTypeCategory::findOrFail($id);

        try {
            $validated = $request->validate([
                'name'        => 'required|string|max:255',
                'slug'        => 'required|string|max:255|unique:document_type_categories,slug,' . $id,
                'description' => 'nullable|string|max:1000',
                'is_active'   => 'boolean',
            ]);

            $validated['is_active'] = $request->boolean('is_active', true);

            $category->update($validated);

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => true, 'message' => 'Category updated successfully.', 'category' => $category]);
            }

            return redirect()->route('admin.masters.document-type-categories.index')
                ->with('success', 'Category updated successfully.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['errors' => $e->errors()], 422);
            }
            throw $e;
        }
    }

    public function destroy(string $id)
    {
        $category = DocumentTypeCategory::findOrFail($id);
        $category->delete();

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Category deleted successfully.']);
        }

        return redirect()->route('admin.masters.document-type-categories.index')
            ->with('success', 'Category deleted successfully.');
    }
}
