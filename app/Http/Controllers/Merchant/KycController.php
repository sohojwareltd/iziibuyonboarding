<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use App\Models\Onboarding;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class KycController extends Controller
{
    public function welcome($kyc_link = null): View
    {
        $onboarding = null;
        if ($kyc_link) {
            $onboarding = Onboarding::where('kyc_link', $kyc_link)->with('solution')->firstOrFail();
        }
        return view('merchant.kyc.welcome', ['onboarding' => $onboarding, 'kyc_link' => $kyc_link]);
    }

    public function company($kyc_link = null): View
    {
        return view('merchant.kyc.company', ['kyc_link' => $kyc_link]);
    }

    public function beneficialOwners($kyc_link = null): View
    {
        return view('merchant.kyc.beneficial-owners', ['kyc_link' => $kyc_link]);
    }

    public function boardMembers($kyc_link = null): View
    {
        return view('merchant.kyc.board-members', ['kyc_link' => $kyc_link]);
    }

    public function contactPerson($kyc_link = null): View
    {
        return view('merchant.kyc.contact-person', ['kyc_link' => $kyc_link]);
    }

    public function purposeOfService($kyc_link = null): View
    {
        return view('merchant.kyc.purpose-of-service', ['kyc_link' => $kyc_link]);
    }

    public function salesChannels($kyc_link = null): View
    {
        return view('merchant.kyc.sales-channels', ['kyc_link' => $kyc_link]);
    }

    public function bankInformation($kyc_link = null): View
    {
        return view('merchant.kyc.bank-information', ['kyc_link' => $kyc_link]);
    }

    public function authorizedSignatories($kyc_link = null): View
    {
        return view('merchant.kyc.authorized-signatories', ['kyc_link' => $kyc_link]);
    }

    public function review($kyc_link = null): View
    {
        return view('merchant.kyc.review', ['kyc_link' => $kyc_link]);
    }

    /**
     * Check authentication status and merchant role
     */
    public function checkAuth(): JsonResponse
    {
        $user = Auth::user();
        $authenticated = $user !== null;
        $isMerchant = $authenticated && (int) $user->role_id === 2;

        return response()->json([
            'authenticated' => $authenticated,
            'is_merchant' => $isMerchant,
            'user' => $isMerchant ? [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role_id' => $user->role_id,
            ] : null,
        ]);
    }

    /**
     * Handle merchant login
     */
    public function login(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'email' => 'required|email',
                'password' => 'required|string|min:6',
                'kyc_link' => 'nullable|string',
            ]);

            // Attempt authentication
            if (!Auth::attempt(['email' => $validated['email'], 'password' => $validated['password']], 
                               (bool) $request->input('remember'))) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid email or password.',
                ], 401);
            }

            $user = Auth::user();

            // Check if user has merchant role
            if ((int) $user->role_id !== 2) {
                Auth::logout();
                return response()->json([
                    'success' => false,
                    'message' => 'This account does not have merchant access.',
                ], 403);
            }

            // Regenerate session to prevent fixation attacks
            $request->session()->regenerate();

            return response()->json([
                'success' => true,
                'message' => 'Logged in successfully',
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role_id' => $user->role_id,
                ],
                'redirect_url' => route('merchant.kyc.company', ['kyc_link' => $validated['kyc_link'] ?? null]),
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred during login',
            ], 500);
        }
    }
}
