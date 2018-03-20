<?php

namespace App\Http\Controllers\Api;


use App\Http\Requests\Api\AuthorizationRequest;

class AuthorizationsController extends ApiController
{
	public function __construct()
	{
		//$this->middleware('auth:api',['except'=>'login']);
	}

	public function login(AuthorizationRequest $request)
	{
		$credentials['email'] = $request->email;
		$credentials['password'] = $request->password;
		//return response($credentials);
		if (!$token = \Auth::guard('api')->attempt($credentials)) {
			return $this->response->errorUnauthorized('用户名或密码错误');
		}

		return $this->response->array([
			'access_token' => $token,
			'token_type' => 'Bearer',
			'expires_in' => \Auth::guard('api')->factory()->getTTL() * 60
		])->setStatusCode(201);
	}


	public function refresh()
	{
		$token = \Auth::guard('api')->refresh();
		return $this->respondWithToken($token);
	}

	public function destroy()
	{
		\Auth::guard('api')->logout();
		return $this->response->noContent();
	}

	protected function respondWithToken($token)
	{
		return $this->response->array([
			'access_token' => $token,
			'token_type' => 'Bearer',
			'expires_in' => \Auth::guard('api')->factory()->getTTL() * 60
		]);
	}

	public function me() {
		$user = \Auth::guard('api')->user();
		return response(['user'=>$user]);
	}
}
