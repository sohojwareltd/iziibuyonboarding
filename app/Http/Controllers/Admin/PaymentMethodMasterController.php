<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentMethodMaster;
use App\Models\AcquirerMaster;
use App\Models\SolutionMaster;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PaymentMethodMasterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = PaymentMethodMaster::query();

        if ($search = request('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('display_label', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('scheme', 'like', "%{$search}%");
            });
        }

        if ($category = request('category')) {
            $query->where('category', $category);
        }

        if ($status = request('status')) {
            $query->where('is_active', $status === 'active');
        }

        if ($country = request('country')) {
            $query->whereJsonContains('supported_countries', $country);
        }

        $paymentMethods = $query->latest()->paginate(15)->withQueryString();
        $acquirers = AcquirerMaster::where('is_active', true)->get();
        $solutions = SolutionMaster::all();
        $countries = PaymentMethodMaster::select('supported_countries')
            ->get()
            ->pluck('supported_countries')
            ->filter()
            ->flatMap(function ($item) {
                if (is_string($item)) {
                    $item = json_decode($item, true) ?? [];
                }
                return is_array($item) ? $item : [];
            })
            ->unique()
            ->sort()
            ->values();
        
        return view('admin.masters.payment-method-master', [
            'paymentMethods' => $paymentMethods,
            'acquirers' => $acquirers,
            'solutions' => $solutions,
            'countries' => $countries,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Parse JSON fields if they come as strings BEFORE validation
        $input = $request->all();
        
        if (isset($input['supported_countries']) && is_string($input['supported_countries'])) {
            $input['supported_countries'] = json_decode($input['supported_countries'], true) ?? [];
        }
        
        if (isset($input['supported_acquirers']) && is_string($input['supported_acquirers'])) {
            $input['supported_acquirers'] = json_decode($input['supported_acquirers'], true) ?? [];
        }
        
        if (isset($input['supported_solutions']) && is_string($input['supported_solutions'])) {
            $input['supported_solutions'] = json_decode($input['supported_solutions'], true) ?? [];
        }

        // Convert string boolean values to actual booleans
        $input['is_active'] = isset($input['is_active']) ? (bool)$input['is_active'] : true;
        $input['supports_3ds'] = isset($input['supports_3ds']) && $input['supports_3ds'] !== '0';
        $input['allows_tokenization'] = isset($input['allows_tokenization']) && $input['allows_tokenization'] !== '0';
        $input['requires_additional_documents'] = isset($input['requires_additional_documents']) && $input['requires_additional_documents'] !== '0';
        $input['requires_acquirer_configuration'] = isset($input['requires_acquirer_configuration']) && $input['requires_acquirer_configuration'] !== '0';

        // Replace request input with parsed data
        $request->merge($input);

        $validated = $request->validate([
            'name' => 'required|string|unique:payment_method_masters|max:255',
            'display_label' => 'required|string|max:255',
            'category' => 'required|in:card,wallet,bank',
            'description' => 'nullable|string',
            'supported_countries' => 'nullable|array',
            'supported_acquirers' => 'nullable|array',
            'supported_solutions' => 'nullable|array',
            'scheme' => 'nullable|string|max:255',
            'supports_3ds' => 'boolean',
            'allows_tokenization' => 'boolean',
            'is_active' => 'boolean',
            'notes' => 'nullable|string',
            'requires_additional_documents' => 'boolean',
            'requires_acquirer_configuration' => 'boolean',
        ]);

        // Ensure arrays are stored as JSON
        if (isset($validated['supported_countries']) && is_array($validated['supported_countries'])) {
            $validated['supported_countries'] = json_encode($validated['supported_countries']);
        }

        if (isset($validated['supported_acquirers']) && is_array($validated['supported_acquirers'])) {
            $validated['supported_acquirers'] = json_encode($validated['supported_acquirers']);
        }

        if (isset($validated['supported_solutions']) && is_array($validated['supported_solutions'])) {
            $validated['supported_solutions'] = json_encode($validated['supported_solutions']);
        }

        $paymentMethod = PaymentMethodMaster::create($validated);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Payment method created successfully',
                'data' => $paymentMethod,
            ], 201);
        }

        return redirect()->route('admin.masters.payment-method-master')
            ->with('success', 'Payment method created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $paymentMethod = PaymentMethodMaster::findOrFail($id);
        
        // Ensure arrays are properly decoded
        $paymentMethod_data = $paymentMethod->toArray();
        if (is_string($paymentMethod_data['supported_countries'])) {
            $paymentMethod_data['supported_countries'] = json_decode($paymentMethod_data['supported_countries'], true) ?? [];
        }
        if (is_string($paymentMethod_data['supported_acquirers'])) {
            $paymentMethod_data['supported_acquirers'] = json_decode($paymentMethod_data['supported_acquirers'], true) ?? [];
        }
        if (is_string($paymentMethod_data['supported_solutions'])) {
            $paymentMethod_data['supported_solutions'] = json_decode($paymentMethod_data['supported_solutions'], true) ?? [];
        }

        return response()->json([
            'success' => true,
            'data' => $paymentMethod_data,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $paymentMethod = PaymentMethodMaster::findOrFail($id);

        // Parse JSON fields if they come as strings BEFORE validation
        $input = $request->all();
        
        if (isset($input['supported_countries']) && is_string($input['supported_countries'])) {
            $input['supported_countries'] = json_decode($input['supported_countries'], true) ?? [];
        }
        
        if (isset($input['supported_acquirers']) && is_string($input['supported_acquirers'])) {
            $input['supported_acquirers'] = json_decode($input['supported_acquirers'], true) ?? [];
        }
        
        if (isset($input['supported_solutions']) && is_string($input['supported_solutions'])) {
            $input['supported_solutions'] = json_decode($input['supported_solutions'], true) ?? [];
        }

        // Convert string boolean values to actual booleans
        $input['is_active'] = isset($input['is_active']) ? (bool)$input['is_active'] : false;
        $input['supports_3ds'] = isset($input['supports_3ds']) && $input['supports_3ds'] !== '0';
        $input['allows_tokenization'] = isset($input['allows_tokenization']) && $input['allows_tokenization'] !== '0';
        $input['requires_additional_documents'] = isset($input['requires_additional_documents']) && $input['requires_additional_documents'] !== '0';
        $input['requires_acquirer_configuration'] = isset($input['requires_acquirer_configuration']) && $input['requires_acquirer_configuration'] !== '0';

        // Replace request input with parsed data
        $request->merge($input);

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                Rule::unique('payment_method_masters')->ignore($id),
                'max:255',
            ],
            'display_label' => 'required|string|max:255',
            'category' => 'required|in:card,wallet,bank',
            'description' => 'nullable|string',
            'supported_countries' => 'nullable|array',
            'supported_acquirers' => 'nullable|array',
            'supported_solutions' => 'nullable|array',
            'scheme' => 'nullable|string|max:255',
            'supports_3ds' => 'boolean',
            'allows_tokenization' => 'boolean',
            'is_active' => 'boolean',
            'notes' => 'nullable|string',
            'requires_additional_documents' => 'boolean',
            'requires_acquirer_configuration' => 'boolean',
        ]);

        // Ensure arrays are stored as JSON
        if (isset($validated['supported_countries']) && is_array($validated['supported_countries'])) {
            $validated['supported_countries'] = json_encode($validated['supported_countries']);
        }

        if (isset($validated['supported_acquirers']) && is_array($validated['supported_acquirers'])) {
            $validated['supported_acquirers'] = json_encode($validated['supported_acquirers']);
        }

        if (isset($validated['supported_solutions']) && is_array($validated['supported_solutions'])) {
            $validated['supported_solutions'] = json_encode($validated['supported_solutions']);
        }

        $paymentMethod->update($validated);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Payment method updated successfully',
                'data' => $paymentMethod,
            ]);
        }

        return redirect()->route('admin.masters.payment-method-master')
            ->with('success', 'Payment method updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $paymentMethod = PaymentMethodMaster::findOrFail($id);
        $paymentMethod->delete();

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Payment method deleted successfully',
            ]);
        }

        return redirect()->route('admin.masters.payment-method-master')
            ->with('success', 'Payment method deleted successfully');
    }
}
