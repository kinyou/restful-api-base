<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\UserRequest;
use App\Service\Api\UserService;
use App\User;
use Illuminate\Http\Request;

/**
 * # 用户操作类 [UserController]
 *
 * @Resource("User", uri="/api")
 */
class UserController extends ApiController
{
    protected $userService;

    /**
     * UserController constructor.
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
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
     *     "data":
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
        $users = $this->userService->user();

        return $this->respondWithSuccess($users);
        
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

        return $this->setStatusCode(200)->respondWithSuccess('sayHello');
    }

    /**
     * 限流路由api测试
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @Get("/limit")
     * @Versions({"v1"})
     * @Request({})
     * @Response(200, body={
     *     "data":
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
     */
    public function limit()
    {
        return $this->respondWithSuccess(User::all());
    }

    /**
     * 根据用户id获取用户信息
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     *
     * @Get("/user/1")
     * @Versions({"v1"})
     * @Transaction({
     *    @Request({"id":1}),
     *    @Response(200, body={
     *     "data":
     *     {
     *        "id":1,
     *        "name":"Alana Durgan",
     *        "email":"heffertz@example.org",
     *        "created_at":"2018-04-19 12:25:41",
     *        "updated_at":"2018-04-19 12:25:41"
     *     },
     *     "code":200
     *    }),
     *    @Response(404,body={
     *       "data":{
     *          "message":"No query results for model [App\\User] 100"
     *        },
     *        "code":404
     *     })
     *
     * })
     */
    public function show($id)
    {
        $user = $this->userService->userById($id);

        return $this->respondWithSuccess($user);
    }

    /**
     * 用户注册
     *
     * @param UserRequest $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @Post("/user/register")
     * @Versions({"v1"})
     * @Transaction({
     *    @Request({"name":"xingyuanwang","email":"wangxy@novastar.tech","password":"123456"}),
     *    @Response(200, body={
     *     "data":
     *     {
     *        "id":1,
     *        "name":"xingyuanwang",
     *        "email":"wangxy@novastar.tech",
     *        "created_at":"2018-04-19 12:25:41",
     *        "updated_at":"2018-04-19 12:25:41"
     *     },
     *     "code":200
     *    }),
     *    @Response(422,body={
     *       "data":{
     *          "message": {
     *               "email":"The email has already been taken.",
     *               "password": "The password must be at least 6 characters."
     *                 }
     *        },
     *        "code":422
     *     })
     * })
     */
    public function store(UserRequest $request)
    {
        $result = $this->userService->store($request);

        return $this->respondWithSuccess($result);
    }

    /**
     * 更新用户信息
     *
     * @param UserRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     *
     * @Put("/user/update/4")
     * @Versions({"v1"})
     * @Request({"password":"1234567"})
     * @Response(200, body={
     *     "data":
     *     {
     *         "message":1
     *     },
     *     "code":200
     * })
     */
    public function update(UserRequest $request,$id)
    {
        $result = $this->userService->update($request,$id);

        return $this->respondWithSuccess($result);
    }

    /**
     * 删除用户
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     *
     * @Delete("/user/destroy/4")
     * @Versions({"v1"})
     * @Request({})
     * @Response(200, body={
     *     "data":
     *     {
     *         "message":1
     *     },
     *     "code":200
     * })
     */
    public function destroy($id)
    {
        $result = $this->userService->destroy($id);

        return $this->respondWithSuccess($result);
    }

}
