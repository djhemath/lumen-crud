<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\ExpiredException;

class JwtMiddleware{
    public function handle($request, Closure $next, $guard = null){
        // $token = $request->get("token");
        $token = $request->header("token");

        if(!$token){
            return response()->json([
                'error' => 'No token'
            ], 401);
        }

        try{
            $credentials = JWT::decode($token, env('JWT_SECRET'), ['HS256']);
        }
        catch(ExpiredException $e){
            return response()->json([
                'error' => 'Token Expired'
            ], 401);
        }
        catch(Exception $e){
            return response()->json([
                'error' => 'Error in decoding token'
            ], 401);
        }

        $request->auth = true;

        return $next($request);
    }
}

?>