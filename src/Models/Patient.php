<?php

require_once 'Personne.php';
require_once 'Displayable.php';
require_once 'database.php';

class Patient extends Personne implements Displayable
{
    private $dateOfBirth;
    private $gender;
    private $address;
    private $doctorId;
    private static $table = "patients";

    public function __construct(
        $first_name,
        $last_name,
        $email,
        $phone_number,
        $dateOfBirth,
        $gender,
        $address,
        $doctorId,
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

    public function getDateOfBirth()
    {
        return $this->dateOfBirth;
    }

    public function setDateOfBirth($dateOfBirth)
    {
        if (!$this->validator->isValidDate($dateOfBirth)) {
            throw new Exception("Invalid date of birth (Y-m-d required)");
        }
        $this->dateOfBirth = $dateOfBirth;
    }

    public function getGender()
    {
        return $this->gender;
    }

    public function setGender($gender)
    {
        if (!$this->validator->isNotEmpty($gender)) {
            throw new Exception("Gender is required");
        }
        $this->gender = $gender;
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function setAddress($address)
    {
        if (!$this->validator->isNotEmpty($address)) {
            throw new Exception("Address is required");
        }
        $this->address = $address;
    }

    public function getDoctorId()
    {
        return $this->doctorId;
    }

    public function setDoctorId($doctorId)
    {
        if (!$this->validator->isNotEmpty($doctorId)) {
            throw new Exception("Doctor ID is required");
        }
        $this->doctorId = $doctorId;
    }

    public function getAge(): int
    {
        $birthDate = new DateTime($this->dateOfBirth);
        $today = new DateTime();
        return $today->diff($birthDate)->y;
    }

    public function getType(): string
    {
        return "Patient";
    }

    public function __toString(): string
    {
        return "{$this->first_name} {$this->last_name} ({$this->getType()})";
    }

    public function toArray(): array
    {
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

    public static function getDisplayHeaders(): array
    {
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

    public static function create(PDO $db, array $data)
    {
        $sql = "INSERT INTO " . self::$table . " 
                (first_name, last_name, email, phone_number, date_of_birth, gender, address, doctor_id) 
                VALUES (:first_name, :last_name, :email, :phone_number, :date_of_birth, :gender, :address, :doctor_id)";

        $stmt = $db->prepare($sql);
        if ($stmt->execute([
            ':first_name' => $data['first_name'],
            ':last_name' => $data['last_name'],
            ':email' => $data['email'],
            ':phone_number' => $data['phone_number'],
            ':date_of_birth' => $data['date_of_birth'],
            ':gender' => $data['gender'],
            ':address' => $data['address'],
            ':doctor_id' => $data['doctor_id']
        ])) {
            return self::findById($db, $db->lastInsertId());
        }

        return null;
    }
    public static function findAll(PDO $db): array
    {
        $stmt = $db->query("SELECT * FROM " . self::$table);
        $patients = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $patients[] = new self(
                $row['first_name'],
                $row['last_name'],
                $row['email'],
                $row['phone_number'],
                $row['date_of_birth'],
                $row['gender'],
                $row['address'],
                $row['doctor_id']
            );
        }
        return $patients;
    }

    public static function findById(PDO $db, int $id): ?Patient
    {
        $stmt = $db->prepare("SELECT * FROM " . self::$table . " WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return new self(
                $row['first_name'],
                $row['last_name'],
                $row['email'],
                $row['phone_number'],
                $row['date_of_birth'],
                $row['gender'],
                $row['address'],
                $row['doctor_id']
            );
        }
        return null;
    }

    public static function update(PDO $db, int $id, array $data): bool
    {
        $sql = "UPDATE " . self::$table . " SET 
                first_name = :first_name, 
                last_name = :last_name, 
                email = :email, 
                phone_number = :phone_number, 
                date_of_birth = :date_of_birth, 
                gender = :gender, 
                address = :address, 
                doctor_id = :doctor_id 
                WHERE id = :id";

        $stmt = $db->prepare($sql);
        return $stmt->execute([
            ':first_name' => $data['first_name'],
            ':last_name' => $data['last_name'],
            ':email' => $data['email'],
            ':phone_number' => $data['phone_number'],
            ':date_of_birth' => $data['date_of_birth'],
            ':gender' => $data['gender'],
            ':address' => $data['address'],
            ':doctor_id' => $data['doctor_id'],
            ':id' => $id
        ]);
    }

    public static function delete(PDO $db, int $id): bool
    {
        $stmt = $db->prepare("DELETE FROM " . self::$table . " WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }

    public static function search(PDO $db, string $keyword): array
    {
        $stmt = $db->prepare("SELECT * FROM " . self::$table . " 
                              WHERE first_name LIKE :kw 
                              OR last_name LIKE :kw 
                              OR email LIKE :kw 
                              OR phone_number LIKE :kw");
        $stmt->execute([':kw' => "%$keyword%"]);

        $patients = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $patients[] = new self(
                $row['first_name'],
                $row['last_name'],
                $row['email'],
                $row['phone_number'],
                $row['date_of_birth'],
                $row['gender'],
                $row['address'],
                $row['doctor_id']
            );
        }
        return $patients;
    }
}
