<?php

namespace App\Http\Middleware;

use App\Models\AuditLog;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class LogUserActivity
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        try {
            $user = Auth::user();
            $route = $request->route();
            $routeName = $route?->getName();

            if (!$user || empty($routeName)) {
                return $response;
            }

            AuditLog::create([
                'user_id' => $user->id,
                'user_name' => trim(($user->name ?? '') . ' ' . ($user->last_name ?? '')),
                'user_email' => $user->email,
                'method' => $request->method(),
                'route_name' => $routeName,
                'url' => $request->fullUrl(),
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'status_code' => $response->getStatusCode(),
            ]);
        } catch (\Throwable $exception) {
            // Do not block request flow if logging fails.
        }

        return $response;
    }
}
