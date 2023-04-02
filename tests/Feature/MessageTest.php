<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MessageTest extends TestCase
{

    use RefreshDatabase;

    public $user;

    public function setUp() : void {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function test_user_cannot_send_private_message_to_himself() 
    {
        $this->actingAs($this->user)->get("/profile/{$this->user->name}");
        $view = $this->view("profile.guest");
        $view->assertSee("You Cannot Send Private Saraha Messages to Yourself!");
    }

    public function test_visitor_can_access_public_profile_of_specific_user() 
    {
        $response = $this->get(route('guest.profile', $this->user->name));
        $response->assertViewHas('user', $this->user);
    }

    public function test_visitor_can_send_private_message_to_specific_user()
    {
        $response = $this->post(route("user.profile.message", $this->user->name), [
            'body'      => "test message",
            'user_id'   => $this->user->id
        ]);
        $response->assertStatus(302);
        $this->assertDatabaseCount('messages', 1);
    }

    public function test_visitor_cannot_send_empty_message_to_any_user() {
        $response = $this->post(route("user.profile.message", $this->user->name), [
            'body' => "",
            'user_id' => $this->user->id
        ]);
        $response->assertSessionHasErrors('body');        
    }
}



