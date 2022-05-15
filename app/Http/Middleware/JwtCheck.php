<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;
use Exception;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class JwtCheck extends BaseMiddleware
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
        try
        {
            $user = JWTAuth::parseToken()->authenticate();
        }
        catch (Exception $e)
        {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException)
            {
                return response()->json(['status' => '0', 'error' => 'Token is Invalid', 'code' => 201]);
            }
            else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException)
            {
                // If the token is expired, then it will be refreshed and added to the headers
                try
                {
                    \Log::info(JWTAuth::getToken());

                    $refreshed = JWTAuth::refresh(JWTAuth::getToken());
                    $user = JWTAuth::setToken($refreshed)->toUser();
                    header('Authorization:' . $refreshed);
                    header('Access-Control-Expose-Headers: Authorization');
                    $input = $request->all();
                    \Log::info($input);
                    // Input modification
                    if($input['token'])
                    {
                        $input['token'] = $refreshed;
                    }
                    $request->replace($input);
                    \Log::info($request->all()); // Shows modified request
                }
                catch (JWTException $e)
                {
                    return response()->json(['status' => '0', 'error' => 'Authorization Token not found', 'code' => 202]);
                }
                //return response()->json(['status' => 'Token is Expired']);
            }
            else
            {
                return response()->json(['status' => '0', 'error' => 'Authorization Token not found', 'code' => 202]);
            }
        }

        return $next($request);
    }
}