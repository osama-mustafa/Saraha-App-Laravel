<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{

    use RefreshDatabase;
    public $user;

    public function setUp() : void
    {
        parent::setUp();
        $this->user = createUserForTesting("test_user", "test_user@gmail.com");
    }

    public function test_guest_user_can_access_register_page()
    {
        $response = $this->get(route('register'));
        $response->assertViewIs("auth.register");
        $response->assertStatus(200);
        $response->assertSee("Register");
    }

    public function test_authenticated_user_cannot_access_register_page()
    {
        $response = $this->actingAs($this->user)->get(route("register"));
        $response->assertStatus(302);
        $response->assertRedirect(route("home"));
    }

    public function test_authenticated_user_cannot_access_login_page()
    {
       $response = $this->actingAs($this->user)->get(route("login"));
       $response->assertStatus(302);
       $response->assertRedirect(route("home"));
    }

    public function test_guest_user_can_register_account_successfully()
    {
        $response = $this->post(route("register"), [
            "name" => "test_user_two",
            "email" => "test_user_two@gmail.com",
            "password" => "12345678",
            "password_confirmation" => "12345678"
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route("home"));
        $response->assertStatus(302);
        $this->assertDatabaseHas("users", [
            "name" => "test_user_two",
            "email" => "test_user_two@gmail.com",
        ]);
    }

    public function test_user_can_login_successfully()
    {
        $this->user = createUserForTesting("test_user_three", "test_user_three@gmail.com");

        $response = $this->post(route("login"), [
            "email" => "test_user_three@gmail.com",
            "password" => "12345678"
        ]);

        $this->assertAuthenticated();
        $response->assertStatus(302);
        $response->assertRedirect(route("home"));
    }

}
