<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\UserSession;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $uniqueId = $request->route('uniqueId');

        if (is_null($uniqueId)) {
            return redirect()->route('home');
        }

        $session = UserSession::where('uniqueId', $uniqueId)->first();

        if (!$session || $session->status == 0) {
            return redirect()->route('home');
        }

        return $next($request);
    }
}
