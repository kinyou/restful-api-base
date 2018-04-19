<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;


class UserController extends ApiController
{

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
