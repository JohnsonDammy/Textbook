<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ApiAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->guard('api')->user()) {
            if (auth("api")->user()->status == 0) {
                auth()->guard('api')->logout();
                return response()->json(['message' => 'Access Denied', 'data' => "The account for this username has been locked.Please contact to System Admin or try by password resetting", 'status' => 401],401);
            }
            return $next($request);
        }

        return response()->json(['message' => "Unauthorized access","data"=>"User is not logged in or token expried" ,"status" => 401],401);
    }
}
