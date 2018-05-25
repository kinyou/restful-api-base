<?php

namespace App\Http\Controllers\Api;

use App\User;
use Illuminate\Http\Request;

/**
 * # 用户操作类 [UserController]
 *
 * @Resource("User", uri="/api")
 */
class UserController extends ApiController
{

    public function __construct()
    {
        $this->middleware('auth:api',['except'=>'sayHello']);
    }

    /**
     * 显示所有用户
     *
     * 使用 JSON 返回所有注册用户
     *
     * @Get("/user")
     * @Versions({"v1"})
     * @Request({})
     * @Response(200, body={
     *     "users":
     *     {
     *         {
     *          "id":1,
     *          "name":"Alana Durgan",
     *          "email":"heffertz@example.org",
     *          "created_at":"2018-04-19 12:25:41",
     *          "updated_at":"2018-04-19 12:25:41"
     *         },
     *         {
     *           "id": 2,
     *           "name": "Shany Rippin",
     *           "email": "krystal.reichel@example.com",
     *           "created_at": "2018-04-19 12:25:41",
     *           "updated_at": "2018-04-19 12:25:41"
     *         }
     *     },
     *     "code":200
     * })
     *
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
     * 使用 JSON 返回sayHello
     *
     * @Get("/sayHello")
     * @Versions({"v1"})
     * @Request({})
     * @Response(200,body={"data":{"message": "sayHello"},"code":200})
     *
     */
    public function sayHello()
    {
        return $this->response->array([
            'message'=>'sayHello'
        ]);
    }

}
