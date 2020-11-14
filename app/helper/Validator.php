<?php

namespace app\helper;

class Validator {

    public static function isNameValid(string $target) : bool {
        return (bool) preg_match("/[A-Z][a-z]+( [A-Z][a-z]+)?/", $target);
    }

    public static function isEmailValid(string $target) : bool {
        return (bool) preg_match("/^([_a-zA-Z0-9-]+(\\.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+(\\.[a-zA-Z0-9-]+)*(\\.[a-zA-Z]{1,6}))?$/", $target);
    }

    public static function isPasswordValid(string $target) : bool {
        return (bool) preg_match("/^[A-Z](?=.*\\d)(?=.*[a-z])[\\w~@#$%^&*+=`|{}:;!.?\"()\\[\\]]{8,25}$/", $target);
    }
}
