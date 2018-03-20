<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\DemoRequest;

class DemoController extends ApiController
{
    public function sayHello(){
    	    return response('abc');
    }

    public function sayPost(DemoRequest $request){

    	    return response($request->all());
    }
}
