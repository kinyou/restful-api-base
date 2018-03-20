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

$api->version('v1', function($api) {
	$api->get('version', function() {
		return response('this is version v1');
	});
});

$api->version('v2', function($api) {
	$api->get('version', function() {
		return response('this is version v2');
	});
});

$api->version('v1', [
	'namespace' => 'App\Http\Controllers\Api'
],function($api) {

	$api->group([
		'middleware' => 'api.throttle',
		'limit' => 1,
		'expires' => 1,
	],function($api){
		$api->get('sayHello', 'DemoController@sayHello');
	});

	$api->post('authorizations/login', 'AuthorizationsController@login');

	$api->group([
		'middleware' => 'auth:api',
	],function ($api){
		$api->post('authorizations/me', 'AuthorizationsController@me');
		$api->put('authorizations/refresh', 'AuthorizationsController@refresh');
	});

	$api->delete('authorizations/destroy', 'AuthorizationsController@destroy');
	$api->post('sayPost', 'DemoController@sayPost');
});
