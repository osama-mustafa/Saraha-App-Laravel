<?php

use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

    if (!function_exists('isUserEnterOldPasswordCorrectly')) {
        function isUserEnterOldPasswordCorrectly($passwordFromRequest, $passwordInDatabase) {
            return Hash::check($passwordFromRequest, $passwordInDatabase);
        }
    }

    if (! function_exists('createUserForTesting')) {
        function createUserForTesting($name, $email, $is_admin = false) {
            return User::factory()->create([
                "name" => $name,
                "email" => $email,
                "password" => bcrypt("12345678"),
                "is_admin" => $is_admin
            ]);
        }
    }

    if (! function_exists('createMessageForTesting')) {
        function createMessageForTesting($body, $user_id) {
            return Message::factory()->create([
                'body' => $body,
                'user_id' => $user_id
            ]);
        }
    }

?>