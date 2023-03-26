<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
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
        try {
            $user = Auth::user();
            if ($user->role == 3 || $user->role == 2) {
                return response()->json(['status'=>false, 'msg'=>"Sorry! You are Not Admin"]);
            } else {
                return $next($request);
            }
        } catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                return response()->json(['status'=>false, 'msg'=>"Token is Invalid"]);
            } else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                return response()->json(['status'=>false, 'msg'=>"Token is Expired"]);
            } else {
                return response()->json(['status'=>false, 'msg'=>"Authorization Token not found"]);
            }
        }
        return $next($request);
    }
}
