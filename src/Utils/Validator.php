<?php

class Validator
{

    public function isValidEmail($email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        } else {
            return true;
        }
    }

    public function isValidPhone($phone)
    {
        if (!preg_match('/^(?:\+212|0)(6|7)\d{8}$/', $phone)) {
            return false;
        } else {
            return true;
        }
    }

    public function isValidDate($date)
    {
        if (!preg_match('/^(19|20)\d{2}-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01])$/', $date)) {
            return false;
        } else {
            return true;
        }
    }

    public function isNotEmpty($input)
    {
        if (!empty($input)) {
            return true;
        } else {
            return false;
        }
    }
}
