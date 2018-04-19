<?php

namespace App\Http\Controllers\Api;

use App\User;
use Illuminate\Http\Request;


class UserController extends ApiController
{

    public function __construct()
    {
        $this->middleware('auth:api',['except'=>'sayHello']);
    }

    /**
     * 返回测试用户
     *
     * @return mixed
     */
    public function index()
    {
        $users = User::all();

        return $this->response->array([
            'users'=>$users
        ]);
    }

    /**
     * 测试api
     *
     * @return mixed
     */
    public function sayHello()
    {
        return $this->response->array([
            'message'=>'sayHello'
        ]);
    }

}
