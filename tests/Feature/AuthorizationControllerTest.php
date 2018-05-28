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
     * @test
     */
    public function user_success_login()
    {
        $user = factory(User::class)->create();

        $response = $this->json('POST','/api/authorization/login',['name'=>$user->name,'password'=>'123456']);

        $response->assertStatus(200)->assertSeeText($user->name);
    }

    /**
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
}
