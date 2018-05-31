<?php

namespace Tests\Feature;

use Dingo\Api\Exception\RateLimitExceededException;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserControllerTest extends TestCase
{
    use DatabaseMigrations;

    protected $user;
    protected $token;

    public function setUp()
    {
        parent::setUp();
        $this->user = factory(User::class)->create();
        $this->token = Auth::guard('api')->fromUser($this->user);

    }

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
        $response = $this->withHeaders(['Authorization'=>'Bearer ' . $this->token])
            ->json('GET','/api/user');

        $response->assertStatus(200)->assertSeeText($this->user->name);
    }

    /**
     * @test
     */
    public function rate_limit_request()
    {
        for($i=0;$i<4;$i++) {
            $response = $this->withHeaders(['Authorization'=>'Bearer ' . $this->token])
                ->json('GET','/api/limit');
        }
        //RateLimitExceededException

        $this->assertInstanceOf(RateLimitExceededException::class,new RateLimitExceededException());

    }

    /**
     * @test
     */
    public function use_id_find_user_success()
    {
        $response = $this->withHeaders(['Authorization'=>'Bearer ' . $this->token])
            ->json('GET','/api/user/' . $this->user->id);

        $response->assertStatus(200)->assertSeeText($this->user->name);
    }

    /**
     * @test
     */
    public function use_id_find_user_fail()
    {
        $response = $this->withHeaders(['Authorization'=>'Bearer ' . $this->token])
            ->json('GET','/api/user/' . ($this->user->id + 1000));

        $response->assertStatus(200)->assertSeeText('No query results for model');
    }

    /**
     * @test
     */
    public function use_register_success()
    {
        $response = $this->json('POST','/api/user/register',['name'=>'maogou','password'=>'123456','email'=>'kinyou_xy@126.com']);

        $response->assertStatus(200)->assertSeeText('maogou');
    }

    /**
     * @test
     */
    public function update_user_success()
    {
        $response = $this->withHeaders(['Authorization'=>'Bearer ' . $this->token])
            ->json('PUT','/api/user/update/' . $this->user->id . '?aa=bb',['password'=>'1234567']);

        $response->assertStatus(200)->assertSeeText('"message":1');
    }

    /**
     * @test
     */
    public function destroy_user_success()
    {
        $response = $this->withHeaders(['Authorization'=>'Bearer ' . $this->token])
            ->json('DELETE','/api/user/destroy/' . $this->user->id);

        $response->assertStatus(200)->assertSeeText('"message":1');
    }
}
