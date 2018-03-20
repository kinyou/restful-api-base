<?php

namespace App\Http\Requests;

use Dingo\Api\Http\FormRequest;

class DemoRequest extends FormRequest
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
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
	        'phone' => 'required|regex:/^1[34578]\d{9}$/',
        ];
    }
}
