<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;

class MiddleToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $req, Closure $next)
    {
        if(!$req->api_token)
            return response()->json("Api token not entered");

        if(!User::where('api_token', $req->api_token)->first())
            return response()->json("User not found");

        return $next($req);
    }
}
