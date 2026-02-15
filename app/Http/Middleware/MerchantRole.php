<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MerchantRole
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user || (int) $user->role_id !== 2) {
            return redirect()->route('merchant.kyc.start', $request->route('kyc_link'));
        }

        return $next($request);
    }
}
