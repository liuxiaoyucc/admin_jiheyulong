<?php

namespace app\http\middleware;

use Firebase\JWT\JWT;
use think\Response;

class Check
{

    public function handle($request, \Closure $next)
    {

        try {
            $token = $request->header('Authorization');

            if (!$token) {
                return json(['code'=> 401, 'message'=> '登录过期, 请重新登录1'])->header('Content-type', 'application/json');
            }

            $decode = JWT::decode($token, config('jwt.jwt_key'), config('jwt.algs'));

            if (!isset($decode->data->user_id)) {
                return json(['code'=> 401, 'message'=> '登录过期, 请重新登录2'])->header('Content-type', 'application/json');
            }
            $request->user_id = $decode->data->user_id;
            $request->session_key = $decode->data->session_key;
            $request->openid = $decode->data->openid;

        }catch (\Exception $e) {
            return json(['code'=> 401, 'message'=> $e->getMessage()])->header('Content-type', 'application/json');
        }

        return $next($request);
    }
}
