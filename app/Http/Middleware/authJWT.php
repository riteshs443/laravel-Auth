<?php
use Illuminate\Http\Request;
namespace App\Http\Middleware;
use App\User;
use Exception;
use App\Http\Response;
use App\Http\Requests;
use JWTAuth;
use Closure;

class authJWT
{
    public function handle($request, Closure $next)
    {
        try {
            $user = JWTAuth::toUser($request->input('token'));
        } catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
                return response()->json(['error'=>'Token is Invalid']);
            }else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
                return response()->json(['error'=>'Token is Expired']);
            }else{
                return response()->json(['error'=>'Something is wrong']);
            }
        }
        return $next($request);
    }
}
