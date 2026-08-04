<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{

    public function test_login_screen_can_be_rendered()
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    // public function test_users_can_authenticate_using_the_login_screen()
    // {
    //     $user = User::factory()->create();

    //     $response = $this->post('/mil/login', [
    //         'email' => $user->email,
    //         'password' => 'password',
    //     ]);

    //     $this->assertAuthenticated();
    //     $response->assertRedirect('http://localhost:8000/mil/dashboard');
    // }

    // public function test_users_can_not_authenticate_with_invalid_password()
    // {
    //     $this->post('/mil/login', [
    //         'email' => 'demo@demo.com',
    //         'password' => 'wrong-password',
    //     ]);

    //     $this->assertGuest();
    // }
}
