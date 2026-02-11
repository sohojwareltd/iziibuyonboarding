<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Country::query();

        // Filter by search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('code', 'LIKE', "%{$search}%");
            });
        }

        $countries = $query->orderBy('name')->paginate(15);

        return view('admin.masters.country', [
            'countries' => $countries,
        ]);
    }

    /**
     * Export Countries to Excel.
     */
    public function export(Request $request)
    {
        $query = Country::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('code', 'LIKE', "%{$search}%");
            });
        }

        $countries = $query->orderBy('name')->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $headers = ['ID', 'Country Name', 'Country Code', 'Created At', 'Updated At'];
        $sheet->fromArray($headers, null, 'A1');

        $row = 2;
        foreach ($countries as $country) {
            $sheet->fromArray([
                $country->id,
                $country->name,
                $country->code,
                optional($country->created_at)->toDateTimeString(),
                optional($country->updated_at)->toDateTimeString(),
            ], null, 'A' . $row);
            $row++;
        }

        return response()->streamDownload(function () use ($spreadsheet) {
            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
        }, 'countries.xlsx', [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.masters.country-form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:countries|max:255',
            'code' => 'required|string|unique:countries|max:3|min:2',
        ]);

        // Uppercase the country code
        $validated['code'] = strtoupper($validated['code']);

        $country = Country::create($validated);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Country created successfully',
                'data' => $country,
            ], 201);
        }

        return redirect()->route('admin.masters.countrys.index')
            ->with('success', 'Country created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $country = Country::findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $country,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $country = Country::findOrFail($id);
        return view('admin.masters.country-form', compact('country'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $country = Country::findOrFail($id);

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                Rule::unique('countries')->ignore($country->id),
                'max:255'
            ],
            'code' => [
                'required',
                'string',
                Rule::unique('countries')->ignore($country->id),
                'max:3',
                'min:2'
            ],
        ]);

        // Uppercase the country code
        $validated['code'] = strtoupper($validated['code']);

        $country->update($validated);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Country updated successfully',
                'data' => $country,
            ]);
        }

        return redirect()->route('admin.masters.countrys.index')
            ->with('success', 'Country updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $country = Country::findOrFail($id);
        $country->delete();

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Country deleted successfully',
            ]);
        }

        return redirect()->route('admin.masters.countrys.index')
            ->with('success', 'Country deleted successfully');
    }
}
