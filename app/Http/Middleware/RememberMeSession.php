<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class RememberMeSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user has a remember cookie but session expired
        // Laravel's StartSession middleware should handle this, but we ensure it works
        if (!Auth::check()) {
            $rememberCookie = $request->cookie(Auth::getRecallerName());
            if ($rememberCookie) {
                // Laravel will automatically check this cookie via the auth guard
                // The remember cookie should re-authenticate the user
            }
        }
        
        $response = $next($request);
        
        // If user is authenticated (including via remember cookie), extend session lifetime
        if (Auth::check() && config('session.driver') === 'database') {
            $sessionId = $request->session()->getId();
            if ($sessionId) {
                $sessionTable = config('session.table', 'sessions');
                
                // Update last_activity to keep session alive
                // This prevents the session from expiring quickly when remember me is used
                DB::table($sessionTable)
                    ->where('id', $sessionId)
                    ->update(['last_activity' => time()]);
            }
        }
        
        return $response;
    }
}

