<?php

namespace App\Http\Controllers\Api;
use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ApiController extends Controller
{
    use Helpers;

    /**
     * @var int
     */
    protected $statusCode = 200;

    /**
     * 设置状态码
     * @param $code
     * @return $this
     */
    public function setStatusCode($code)
    {
        $this->statusCode = $code;

        return $this;
    }

    /**
     * 获取状态码
     * @return int
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * 404
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondNotFound($message = 'Not Found')
    {
        return $this->setStatusCode(404)->respondWithSuccess($message);
    }

    /**
     * 服务器内部错误
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondInternalError($message = 'Internal Error')
    {
        return $this->setStatusCode(500)->respondWithSuccess($message);
    }


    /**
     * 成功响应
     * @param $data
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondWithSuccess($data)
    {
        if (is_string($data)) $data = ['message'=>$data];

        return $this->respond([
            'data'=>$data,
            'code'=>$this->getStatusCode()
        ]);
    }

    /**
     * 统一响应数据
     * @param $data
     * @param array $header
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respond($data,array $header = [])
    {
        return response()->json($data,$this->getStatusCode(),$header);
    }
}
