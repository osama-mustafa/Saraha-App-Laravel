<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;
    public $user;
    public $message;

    public function setUp() : void
    {
        parent::setUp();
        $this->user = createUserForTesting("test_user", "test_user@gmail.com");
        $this->message = createMessageForTesting("test private message to this user", $this->user->id);
    }

    public function test_authenticated_user_can_access_edit_profile_page()
    {
        $response = $this->actingAs($this->user)->get(route('edit.profile'));
        $response->assertStatus(200);
        $response->assertSeeText("Edit Profile");
    }

    public function test_authenticated_user_can_access_change_password_page()
    {
        $response = $this->actingAs($this->user)->get(route('change.password'));
        $response->assertStatus(200);
        $response->assertSeeText("Change Password");
    }

    public function test_authenticated_user_can_delete_his_own_received_message()
    {
        $response = $this->actingAs($this->user)
            ->delete(route("user.delete.message", $this->message->id));
        $response->assertStatus(302);
        $this->assertSoftDeleted($this->message);
    }

    public function test_authenticated_user_can_see_his_own_messages()
    {
        $response = $this->actingAs($this->user)->get(route("user.profile"));
        $response->assertStatus(200);
        $response->assertViewIs("profile.user");
        $response->assertSeeText($this->message->body);
    }
}
