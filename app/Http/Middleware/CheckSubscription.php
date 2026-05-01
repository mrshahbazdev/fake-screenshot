<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckSubscription
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user || !$user->hasActiveSubscription()) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Your subscription has expired.'], 403);
            }
            return redirect()->route('subscription.show')
                ->with('error', 'Your subscription has expired or is inactive. Please activate to continue.');
        }

        return $next($request);
    }
}
