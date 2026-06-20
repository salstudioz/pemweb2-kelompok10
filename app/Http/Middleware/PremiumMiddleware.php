<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PremiumMiddleware {
    public function handle(Request $request, Closure $next): Response {
        if (!$request->user() || ($request->user()->role !== 'premium' && $request->user()->role !== 'admin')) {
            return redirect()->route('upgrade.premium');
        }
        return $next($request);
    }
}