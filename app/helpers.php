<?php

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

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

    if (! function_exists('handleUploadImage')) {
        function handleUploadImage(Request $request, $path = 'public/images') {
            try {
                // Create unique name for the image
                $file  = $request->image;
                $name  =  $file->hashName();

                // Save image to specific directory
                $path = Storage::putFileAs($path, $file, $name);
                return $name;

            } catch (\Throwable $th) {
                return $th->getMessage();
            }
        }
    }

?>