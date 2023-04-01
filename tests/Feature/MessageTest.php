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

    public function test_user_cannot_send_private_message_to_himself() {

        $this->actingAs($this->user)->get("/profile/{$this->user->name}");
        $view = $this->view("profile.guest");
        $view->assertSee("You Cannot Send Private Saraha Messages to Yourself!");
    }


}
