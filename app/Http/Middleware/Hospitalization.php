<?php

namespace App\Http\Middleware;

use Closure;

class Hospitalization 
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

         try {
            $user = auth()->guard('hospitalization')->userOrFail();
            if(!$user) {
                return response()->json(['message' => 'user not found'], 401);
            }
        } catch (\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e) {
            return response()->json(['message' => 'user not defined'], 401);
        }

        return $next($request);
    }
}
