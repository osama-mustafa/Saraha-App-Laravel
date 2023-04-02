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
        $this->user = User::factory()->create();
    }

    public function test_guest_user_can_access_register_page()
    {
        $response = $this->get(route('register'));
        $response->assertViewIs("auth.register");
        $response->assertStatus(200);
        $response->assertSee("Register");
    }
}
