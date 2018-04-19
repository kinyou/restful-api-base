<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class RefreshToken extends BaseMiddleware
{
    /**
     * 自动刷新中间件
     *
     * @param $request
     * @param Closure $next
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     * @throws UnauthorizedHttpException
     * @throws \Tymon\JWTAuth\Exceptions\JWTException
     */

    public function handle($request, Closure $next)
    {
        //检测请求中是否带有token,如果没有则抛出异常
        $this->checkForToken($request);

        try{
            //检测用户是否是登陆状态,如果是在正常继续
            if ($this->auth->parseToken()->authenticate()) {
                return $next($request);
            }

            throw new UnauthorizedHttpException('jwt-auth','no login');
        } catch (TokenExpiredException $exception) {
            //如果用户token过期,自动刷新token
            $token = $this->refresh();
            logger('---------token过期---------');
        }

        //在响应头中返回新的token
        return $this->setAuthenticationHeader($next($request),$token);
    }

    /**
     * 刷新token
     *
     * @return string
     */
    protected function refresh()
    {

        try{
            //刷新用户的token
            $token = $this->auth->refresh();
            //使用一次性登陆保证此次请求的成功
            //$this->auth->manager()->getPayloadFactory()->buildClaimsCollection()->toPlainArray()['sub'] 这个会拿到用户的id
            Auth::guard('api')->onceUsingId($this->auth->manager()->getPayloadFactory()->buildClaimsCollection()->toPlainArray()['sub']);
        } catch (JWTException $exception) {
            //如果捕获到异常说明,refresh 也过期,此时要重新登录
            throw new UnauthorizedHttpException('jwt-auth', $exception->getMessage(), $exception, $exception->getCode());
        }

        return $token;
    }
}
