<?php

require_once __DIR__ . '/../Validator.php';

abstract class Personne
{
    protected $first_name;
    protected $last_name;
    protected $phone_number;
    protected $email;

    protected $validator;

    public function __construct()
    {
        $this->validator = new Validator();
    }

    public function getFirstName()
    {
        return $this->first_name;
    }

    public function setFirstName($first_name)
    {
        if (!$this->validator->isNotEmpty($first_name)) {
            throw new Exception("First name is required");
        }
        $this->first_name = $first_name;
    }

    public function getLastName()
    {
        return $this->last_name;
    }

    public function setLastName($last_name)
    {
        if (!$this->validator->isNotEmpty($last_name)) {
            throw new Exception("Last name is required");
        }
        $this->last_name = $last_name;
    }

    public function getPhoneNumber()
    {
        return $this->phone_number;
    }

    public function setPhoneNumber($phone_number)
    {
        if (!$this->validator->isValidPhone($phone_number)) {
            throw new Exception("Invalid phone number");
        }
        $this->phone_number = $phone_number;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        if (!$this->validator->isValidEmail($email)) {
            throw new Exception("Invalid email");
        }
        $this->email = $email;
    }

    abstract public function getType(): string;
}
