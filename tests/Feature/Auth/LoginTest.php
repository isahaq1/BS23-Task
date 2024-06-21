<?php

namespace Tests\Feature\Auth;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    /**
     * A basic feature test example.
     */
     use RefreshDatabase;

    public function test_a_user_can_register()
    {

        $this->postJson(route('register'),[
            'name' => "Isahaq",
            'email' => 'hmisahaq01@gmail.com',
            'password' => 'secret123',
            'password_confirmation' => 'secret123',
        ])->assertCreated();

        $this->assertDatabaseHas('users',['name' => 'Isahaq']);
    }

    public function test_a_user_can_login_with_email_and_password()
    {
        $user = User::create([
            'name' => 'Isahaq',
            'email' => 'bdisahaq@gmail.com',
           'password' => bcrypt('12345678')
        ]);

        $response = $this->postJson(route('login'),[
            'email' => $user->email,
            'password' =>  '12345678'
        ])
        ->assertOk();

        
    }

}
