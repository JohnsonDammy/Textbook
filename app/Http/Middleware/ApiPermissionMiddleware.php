<?php

namespace App\Http\Middleware;
use Closure;
use Illuminate\Support\Facades\Request;
use Spatie\Permission\Exceptions\UnauthorizedException;

class ApiPermissionMiddleware
{
    public function handle($request, Closure $next, $permission, $guard = null)
    {
        $authGuard = app('auth')->guard($guard);
        $request = Request::capture();
        if ($request->is('api/*')) {
            $authGuard = app('auth')->guard("api");
        }

        if ($authGuard->guest()) {
            throw UnauthorizedException::notLoggedIn();
        }

        $permissions = is_array($permission)
            ? $permission
            : explode('|', $permission);

        foreach ($permissions as $permission) {
            if ($authGuard->user()->can($permission)) {
                return $next($request);
            }
        }

        if ($request->is("api/*")) {
            return response()->json(["message" => "You do not have access to this feature", "data" => ""], 403);
        }
        throw UnauthorizedException::forPermissions($permissions);
    }
}

