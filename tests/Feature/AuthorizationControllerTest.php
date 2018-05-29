<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthorizationControllerTest extends TestCase
{
    use DatabaseMigrations;


    /**
     * 登录
     *
     * @test
     */
    public function user_success_login()
    {
        $user = factory(User::class)->create();

        $response = $this->json('POST','/api/authorization/login',['name'=>$user->name,'password'=>'123456']);

        $response->assertStatus(200)->assertSeeText($user->name);
    }

    /**
     * 退出
     *
     * @test
     */
    public function user_success_logout()
    {
        $user = factory(User::class)->create();
        $token = Auth::guard('api')->fromUser($user);

        $response = $this->withHeaders(['Authorization'=>'Bearer ' . $token])
            ->json('DELETE','/api/authorization/logout');
        
        $response->assertStatus(200)->assertSeeText('success');
    }

    /**
     * 使用错误用户密码登录
     *
     * @test
     */
    public function user_login_use_error_password()
    {
        $user = factory(User::class)->create();

        $response = $this->json('POST','/api/authorization/login',['name'=>$user->name,'password'=>'1234567']);

        $response->assertStatus(200)->assertExactJson(['data'=>['message'=>'用户名或者密码错误'],'code'=>422]);
    }

    /**
     * 刷新token
     *
     * @test
     */
    public function refresh_token_use_old_token()
    {
        $user = factory(User::class)->create();
        $token = Auth::guard('api')->fromUser($user);

        $response = $this->withHeaders(['Authorization'=>'Bearer ' . $token])
            ->json('PUT','/api/authorization/refresh');
        
        $response->assertStatus(200)->assertSeeText($user->name);
    }
}
