<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

$api = app('Dingo\Api\Routing\Router');

//测试路由
$api->version('v1', ['namespace' => 'App\Http\Controllers\Api'

], function($api) {
	$api->get('sayHello', 'UserController@sayHello');
});

$api->version('v1', [
	'namespace' => 'App\Http\Controllers\Api'
],function($api) {

	$api->post('authorization/login', 'AuthorizationController@login');
	$api->delete('authorization/destroy', 'AuthorizationController@destroy');

	//自动刷新token
	//$api->group(['middleware'=>'refresh.token'],function($api){
		$api->get('user', 'UserController@index');
	//});
});
