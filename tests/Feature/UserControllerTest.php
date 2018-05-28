<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserControllerTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * 测试api接口是否正确
     *
     * @test
     */
    public function say_hello()
    {
        $response = $this->get('/api/sayHello');
        $response->assertExactJson([
            'data'=>['message'=>'sayHello'],
            'code'=>200
        ]);
    }

    /**
     * 测试用户列表
     *
     * @test
     */
    public function user_list()
    {
        $user = factory(User::class)->create();
        $token = Auth::guard('api')->fromUser($user);

        $response = $this->withHeaders(['Authorization'=>'Bearer ' . $token])
            ->json('GET','/api/user');

        $response->assertStatus(200)->assertSeeText($user->name);
    }
}
