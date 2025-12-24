<?php

require_once 'Personne.php';
require_once 'Displayable.php';

class Patient extends Personne implements Displayable
{
    private $dateOfBirth;
    private $gender;
    private $address;
    private $doctorId;

    public function __construct(
        $first_name,
        $last_name,
        $email,
        $phone_number,
        $dateOfBirth,
        $gender,
        $address,
        $doctorId
    ) {
        parent::__construct();

        $this->setFirstName($first_name);
        $this->setLastName($last_name);
        $this->setEmail($email);
        $this->setPhoneNumber($phone_number);

        $this->setDateOfBirth($dateOfBirth);
        $this->setGender($gender);
        $this->setAddress($address);
        $this->setDoctorId($doctorId);
    }

    public function getDateOfBirth() {
        return $this->dateOfBirth;
    }

    public function setDateOfBirth($dateOfBirth) {
        if (!$this->validator->isValidDate($dateOfBirth)) {
            throw new Exception("Invalid date of birth (Y-m-d required)");
        }
        $this->dateOfBirth = $dateOfBirth;
    }

    public function getGender() {
        return $this->gender;
    }

    public function setGender($gender) {
        if (!$this->validator->isNotEmpty($gender)) {
            throw new Exception("Gender is required");
        }
        $this->gender = $gender;
    }

    public function getAddress() {
        return $this->address;
    }

    public function setAddress($address) {
        if (!$this->validator->isNotEmpty($address)) {
            throw new Exception("Address is required");
        }
        $this->address = $address;
    }

    public function getDoctorId() {
        return $this->doctorId;
    }

    public function setDoctorId($doctorId) {
        if (!$this->validator->isNotEmpty($doctorId)) {
            throw new Exception("Doctor ID is required");
        }
        $this->doctorId = $doctorId;
    }

    public function getAge(): int {
        $birthDate = new DateTime($this->dateOfBirth);
        $today = new DateTime();
        return $today->diff($birthDate)->y;
    }

    public function getType(): string {
        return "Patient";
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
            'date_of_birth' => $this->dateOfBirth,
            'age' => $this->getAge(),
            'gender' => $this->gender,
            'address' => $this->address,
            'doctor_id' => $this->doctorId,
            'type' => $this->getType()
        ];
    }

    public static function getDisplayHeaders(): array {
        return [
            'First Name',
            'Last Name',
            'Email',
            'Phone',
            'Date of Birth',
            'Age',
            'Gender',
            'Address',
            'Doctor ID',
            'Type'
        ];
    }
}
