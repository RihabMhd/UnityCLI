<?php

require_once 'Personne.php';
require_once 'Displayable.php';

class Doctor extends Personne implements Displayable
{
    private $specialization;
    private $departmentId;
    private static $table = "doctors";

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

    public function getspecialization()
    {
        return $this->specialization;
    }

    public function setSpecialization($specialization)
    {
        if (!$this->validator->isNotEmpty($specialization)) {
            throw new Exception("Specialization is required");
        }
        $this->specialization = $specialization;
    }

    public function getDepartmentId()
    {
        return $this->departmentId;
    }

    public function setDepartmentId($departmentId)
    {
        if (!$this->validator->isNotEmpty($departmentId)) {
            throw new Exception("department Id is required");
        }
        $this->departmentId = $departmentId;
    }


    public function getType(): string
    {
        return "Doctor";
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
            'Specialization' => $this->specialization,
            'Department ID' => $this->departmentId,
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
            'Specialization',
            'Department ID',
        ];
    }

    public static function create(PDO $db, array $data)
    {
        $sql = "INSERT INTO " . self::$table . " 
                (first_name, last_name, specialisation, phone_number, email, department_id) 
                VALUES (:first_name, :last_name, :specialisation, :phone_number, :email, :department_id)";

        $stmt = $db->prepare($sql);
        if ($stmt->execute([
            ':first_name' => $data['first_name'],
            ':last_name' => $data['last_name'],
            ':specialisation' => $data['specialisation'],
            ':phone_number' => $data['phone_number'],
            ':email' => $data['email'],
            ':department_id' => $data['department_id']
        ])) {
            return self::findById($db, $db->lastInsertId());
        }

        return null;
    }
    public static function findAll(PDO $db): array
    {
        $stmt = $db->query("SELECT * FROM " . self::$table);
        $doctors = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $doctors[] = new self(
                $row['first_name'],
                $row['last_name'],
                $row['specialisation'],
                $row['phone_number'],
                $row['email'],
                $row['department_id']
            );
        }
        return $doctors;
    }

    public static function findById(PDO $db, int $id): ?Doctor
    {
        $stmt = $db->prepare("SELECT * FROM " . self::$table . " WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return new self(
                $row['first_name'],
                $row['last_name'],
                $row['specialisation'],
                $row['phone_number'],
                $row['email'],
                $row['department_id']
            );
        }
        return null;
    }

    public static function update(PDO $db, int $id, array $data): bool
    {
        $sql = "UPDATE " . self::$table . " SET 
                first_name = :first_name, 
                last_name = :last_name, 
                specialisation = :specialisation, 
                phone_number = :phone_number, 
                email = :email, 
                department_id = :department_id";

        $stmt = $db->prepare($sql);
        return $stmt->execute([
            ':first_name' => $data['first_name'],
            ':last_name' => $data['last_name'],
            ':specialisation' => $data['specialisation'],
            ':phone_number' => $data['phone_number'],
            ':email' => $data['email'],
            ':department_id' => $data['department_id'],
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
                              OR specialisation LIKE :kw 
                              OR phone_number LIKE :kw
                              OR email LIKE :kw ");
        $stmt->execute([':kw' => "%$keyword%"]);

        $doctors = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $doctors[] = new self(
                $row['first_name'],
                $row['last_name'],
                $row['specialisation'],
                $row['phone_number'],
                $row['email'],
                $row['department_id']
            );
        }
        return $doctors;
    }
}
