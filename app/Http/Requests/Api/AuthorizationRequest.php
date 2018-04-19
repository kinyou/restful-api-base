<?php

namespace App\Http\Requests\Api;

use Dingo\Api\Http\FormRequest;
use Illuminate\Http\Request;

class AuthorizationRequest extends FormRequest
{
    /**
     *
     * 判断用户是否具有权限请求表单验证
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * 定义表单验证规则
     *
     * @param Request $request
     * @return array
     */

    public function rules(Request $request)
    {
        //使用这种模式可以对同一个post请求,有些字段必须有,有些又是可有可无的情况
        $case = $request->method() . '-' . strtoupper(str_replace('/', '-', $request->path()));

        switch ($case) {
            case 'POST-API-AUTHORIZATION-LOGIN' :
                return [
                    'name' => 'required',
                    'password' => 'required|string|min:6',
                ];
                break;

            default:
                return [];
                break;
        }

    }
}
