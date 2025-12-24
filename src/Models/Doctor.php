<?php

require_once 'Personne.php';
require_once 'Displayable.php';

class Doctor extends Personne implements Displayable
{
    private $specialization;
    private $departmentId;

    public function __construct(
        $first_name,
        $last_name,
        $email,
        $phone_number,
        $specialization,
        $departmentId,
    ) {
        parent::__construct();

        $this->setFirstName($first_name);
        $this->setLastName($last_name);
        $this->setEmail($email);
        $this->setPhoneNumber($phone_number);

        $this->setSpecialization($specialization);
        $this->setDepartmentId($departmentId);
    }

    public function getspecialization() {
        return $this->specialization;
    }

    public function setSpecialization($specialization) {
        if (!$this->validator->isNotEmpty($specialization)) {
            throw new Exception("Specialization is required");
        }
        $this->specialization = $specialization;
    }

    public function getDepartmentId() {
        return $this->departmentId;
    }

    public function setDepartmentId($departmentId) {
        if (!$this->validator->isNotEmpty($departmentId)) {
            throw new Exception("department Id is required");
        }
        $this->departmentId = $departmentId;
    }


    public function getType(): string {
        return "Doctor";
    }

    public function __toString(): string {
        return "{$this->first_name} {$this->last_name} ({$this->getType()})";
    }

    public function toArray(): array {
        return [
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'phone_number' => $this->phone_number,
            'Specialization' => $this->specialization,
            'Department ID' => $this->departmentId,
            'type' => $this->getType()
        ];
    }

    public static function getDisplayHeaders(): array {
        return [
            'First Name',
            'Last Name',
            'Email',
            'Phone',
            'Specialization',
            'Department ID',
        ];
    }
}
