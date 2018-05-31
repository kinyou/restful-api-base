<?php

namespace App\Http\Requests\Api;

use Dingo\Api\Http\FormRequest;
use Illuminate\Http\Request;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * @param Request $request
     * @return array
     */
    public function rules(Request $request)
    {
        //使用这种模式可以对同一个post请求,有些字段必须有,有些又是可有可无的情况
        $path = preg_match('/[0-9]+/',$request->path(),$matches) ? str_replace($matches[0],'',$request->path()) : $request->path();
        $case = rtrim($request->method() . '-' . strtoupper(str_replace('/', '-', $path)),'-');

        switch ($case) {
            case 'POST-API-USER-REGISTER' :
                return [
                    'name' => 'required|string|max:255|unique:users',
                    'email' => 'required|string|email|max:255|unique:users',
                    'password' => 'required|string|min:6',
                ];
                break;
            case 'PUT-API-USER-UPDATE' :
                return [
                    'password' => 'required|string|min:6',
                ];
                break;
            default:
                return [];
                break;
        }
    }
}
