<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = $request->user();

        if (!$user || !$user->role || !in_array($user->role->name, $roles)) {
            abort(403, 'Unauthorized access.');
        }

        return $next($request);
    }
}