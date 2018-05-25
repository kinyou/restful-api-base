<?php

namespace App\Http\Controllers\Api;


use App\Exceptions\RestfulException;
use App\Http\Requests\Api\AuthorizationRequest;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;


class AuthorizationController extends ApiController
{
    /**
     * 权限认证
     * AuthorizationsController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => 'login']);
    }

    /**
     * 登录
     * @param AuthorizationRequest $request
     * @return mixed
     * @throws RestfulException
     */
    public function login(AuthorizationRequest $request)
    {
        $credentials['name'] = $request->name;
        $credentials['password'] = $request->password;

        if (!$token = Auth::guard('api')->attempt($credentials)) {
            throw new RestfulException('用户名或者密码错误', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return $this->responseWithToken($token);
    }

    /**
     * 备用刷新token
     * 已经是用中间件实现了自动刷新token
     *
     * @return mixed
     */
    public function refresh()
    {
        $token = Auth::guard('api')->refresh();

        return $this->responseWithToken($token);
    }

    /**
     *
     * 销毁token退出登录
     *
     * @return \Dingo\Api\Http\Response
     */
    public function logout()
    {
        Auth::guard('api')->logout();

        return $this->respondWithSuccess('success');
    }


    /**
     * 响应token
     *
     * @param $token
     * @return mixed
     */
    protected function responseWithToken($token)
    {
        return $this->respondWithSuccess([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => Auth::guard('api')->factory()->getTTL() * 60,
            'user' => Auth::guard('api')->user()
        ]);
    }
}
