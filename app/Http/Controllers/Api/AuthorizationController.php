<?php

namespace App\Http\Controllers\Api;


use App\Http\Requests\Api\AuthorizationRequest;
use Illuminate\Support\Facades\Auth;


class AuthorizationController extends ApiController
{
    /**
     * 权限认证
     * AuthorizationsController constructor.
     */
	public function __construct()
	{
		$this->middleware('auth:api',['except'=>'login']);
	}

    /**
     * 登录
     *
     * @param AuthorizationRequest $request
     * @return mixed|void
     */
	public function login(AuthorizationRequest $request)
	{
		$credentials['name'] = $request->name;
		$credentials['password'] = $request->password;
		//return response($credentials);

		if (!$token =Auth::guard('api')->attempt($credentials)) {
			return $this->response->errorUnauthorized('用户名或密码错误');
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

		return $this->response->array([
			'logout'=>'success'
		]);
	}


	/**
	 * 响应token
	 *
	 * @param $token
	 * @return mixed
	 */
	protected function responseWithToken($token)
	{
		return $this->response->array([
			'access_token' => $token,
			'token_type' => 'Bearer',
			'expires_in' => Auth::guard('api')->factory()->getTTL() * 60,
			'user'=>Auth::guard('api')->user()
		]);
	}
}
