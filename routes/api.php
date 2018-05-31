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
	$api->delete('authorization/logout', 'AuthorizationController@logout');
	$api->put('authorization/refresh', 'AuthorizationController@refresh');

	//自动刷新token
	//$api->group(['middleware'=>'refresh.token'],function($api){
		$api->get('user', 'UserController@index');
	//});

	$api->get('user/{id}','UserController@show');
	$api->post('user/register','UserController@store');
});

//限流测试路由
$api->version('v1', ['namespace' => 'App\Http\Controllers\Api'

], function($api) {
	$api->group(['middleware'=>'api.throttle','limit'=>2,'expires'=>1],function($api){
		$api->get('limit', 'UserController@limit');
	});

});