<?php

namespace App\Http\Middleware;

use App\Models\Onboarding;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class KycSubmissionGate
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $kycLink = $request->route('kyc_link');

        if (!$kycLink) {
            return $next($request);
        }

        $onboarding = Onboarding::where('kyc_link', $kycLink)->first();

        if (!$onboarding) {
            return $next($request);
        }

        $currentRouteName = $request->route()?->getName();
        $allowedRoutes = [
            'merchant.kyc.thankyou',
        ];

        if (!is_null($onboarding->review_declaration_accepted_at)
            && $onboarding->status === 'in-review'
            && !in_array($currentRouteName, $allowedRoutes, true)) {
            return redirect()->route('merchant.kyc.thankyou', ['kyc_link' => $kycLink]);
        }

        return $next($request);
    }
}
