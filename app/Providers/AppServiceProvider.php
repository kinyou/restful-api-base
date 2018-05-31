<?php

namespace App\Providers;

use App\Exceptions\RestfulException;
use Dingo\Api\Exception\ValidationHttpException;
use Dingo\Api\Facade\API;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\HttpFoundation\Response;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (app()->environment() != 'production') {
            logger('==================== URL: ' . request()->fullUrl() . ' ====================');
            DB::listen(function(QueryExecuted $queryExecuted) {
                $executeSql = str_replace(['%','?'],['%%','%s'],$queryExecuted->sql);
                $bindings = $queryExecuted->connection->prepareBindings($queryExecuted->bindings);
                $pdo = $queryExecuted->connection->getPdo();
                logger(vsprintf($executeSql,array_map([$pdo,'quote'],$bindings)));
            });
        }
        //更改默认的dingo/api的模型未找到500变为404
        API::error(function(ModelNotFoundException $modelNotFoundException){
            return $this->respondWithError($modelNotFoundException->getMessage(),Response::HTTP_NOT_FOUND);
        });

        //更改默认的dingo/api的参数效验错误为422
        API::error(function(ValidationHttpException $validationHttpException){
            return $this->respondWithError($validationHttpException->getErrors(),Response::HTTP_UNPROCESSABLE_ENTITY);
        });

        //更改默认的dingo/api的未登录请求为403
        API::error(function(AuthenticationException $authenticationException){
            return $this->respondWithError($authenticationException->getMessage(),Response::HTTP_FORBIDDEN);
        });

        //注册统一接管用户自定义的响应
        app('Dingo\Api\Exception\Handler')->register(function(RestfulException $restfulException){
            $code = $restfulException->getCode() ?: Response::HTTP_INTERNAL_SERVER_ERROR;
            return $this->respondWithError($restfulException->getMessage(),$code);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * 统一响应异常数据结构
     * @param string $data
     * @param int $code
     * @return mixed
     */
    protected function respondWithError($data='',$code=200)
    {
        return response()->json([
            'data'=>['message'=>$data],
            'code'=>$code
        ]);
    }
}
