<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SolutionMaster;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class SolutionMasterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = SolutionMaster::with('category');

        // Filter by search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%");
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by country
        if ($request->filled('country')) {
            $query->where('country', $request->country);
        }

        $solutions = $query->get();
        $categories = Category::all();
        
        // Get unique countries for filter dropdown
        $countries = SolutionMaster::whereNotNull('country')
            ->distinct('country')
            ->pluck('country')
            ->sort();

        return view('admin.masters.solution-master', compact('solutions', 'categories', 'countries'));
    }

    /**
     * Export Solution Master data to Excel.
     */
    public function export(Request $request)
    {
        $query = SolutionMaster::with('category');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('description', 'LIKE', "%{$search}%");
            });
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('country')) {
            $query->where('country', $request->country);
        }

        $solutions = $query->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $headers = [
            'ID',
            'Name',
            'Slug',
            'Category',
            'Status',
            'Description',
            'Country',
            'Tags',
            'Acquirers',
            'Payment Methods',
            'Alternative Methods',
            'Requirements',
            'Pricing Plan',
            'Created At',
            'Updated At',
        ];

        $sheet->fromArray($headers, null, 'A1');

        $row = 2;
        foreach ($solutions as $solution) {
            $sheet->fromArray([
                $solution->id,
                $solution->name,
                $solution->slug,
                $solution->category?->name ?? '',
                $solution->status,
                $solution->description,
                $solution->country,
                $this->implodeArray($solution->tags),
                $this->implodeArray($solution->acquirers),
                $this->implodeArray($solution->payment_methods),
                $this->implodeArray($solution->alternative_methods),
                $solution->requirements,
                $solution->pricing_plan,
                optional($solution->created_at)->toDateTimeString(),
                optional($solution->updated_at)->toDateTimeString(),
            ], null, 'A' . $row);
            $row++;
        }

        return response()->streamDownload(function () use ($spreadsheet) {
            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
        }, 'solution-master.xlsx', [
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
