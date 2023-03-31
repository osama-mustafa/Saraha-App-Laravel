<?php 

use Illuminate\Support\Facades\Hash;

    if (!function_exists('confirmOldPasswordBeforeUpdateIt')) {
        function confirmOldPasswordBeforeUpdateIt($passwordFromRequest, $passwordInDatabase) {
            return Hash::check($passwordFromRequest, $passwordInDatabase);
        }
    }

?>