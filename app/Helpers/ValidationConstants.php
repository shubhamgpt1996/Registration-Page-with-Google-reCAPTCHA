<?php
namespace app\Helpers;


class ValidationConstants {
    CONST USER_VALIDATION = [
        'name' => 'required|string',
        'email' => 'required|email',
        'password' => 'required|string'
    ];
}
?>
