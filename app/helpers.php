<?php 

use Illuminate\Support\Facades\Hash;

    if (!function_exists('isUserEnterOldPasswordCorrectly')) {
        function isUserEnterOldPasswordCorrectly($passwordFromRequest, $passwordInDatabase) {
            return Hash::check($passwordFromRequest, $passwordInDatabase);
        }
    }

?>