<?php

require_once 'Displayable.php';
require_once __DIR__ . '/../Validator.php';

class Department implements Displayable
{
    private $departmentName;
    private $location;
    protected $validator;
    private static $table = "departments";


    public function __construct(
        $departmentName,
        $location,
    ) {

        $this->setDepartmentName($departmentName);
        $this->setLocation($location);
        $this->validator = new Validator();
    }

    public function getDepartmentName()
    {
        return $this->departmentName;
    }

    public function setDepartmentName($departmentName)
    {
        if (!$this->validator->isNotEmpty($departmentName)) {
            throw new Exception("Department Name is required");
        }
        $this->departmentName = $departmentName;
    }

    public function getLocation()
    {
        return $this->location;
    }

    public function setLocation($location)
    {
        if (!$this->validator->isNotEmpty($location)) {
            throw new Exception("Location is required");
        }
        $this->location = $location;
    }

    public function getType(): string
    {
        return "Department";
    }

    public function __toString(): string
    {
        return "{$this->departmentName} {$this->location} ({$this->getType()})";
    }

    public function toArray(): array
    {
        return [
            'department_ame' => $this->departmentName,
            'location' => $this->location,
            'type' => $this->getType()
        ];
    }

    public static function getDisplayHeaders(): array
    {
        return [
            'Department Name',
            'Location',
            'Type'
        ];
    }
    public static function create(PDO $db, array $data)
    {
        $sql = "INSERT INTO " . self::$table . " 
                (department_name, location) 
                VALUES (:department_name, :location)";

        $stmt = $db->prepare($sql);
        if ($stmt->execute([
            ':department_name' => $data['department_name'],
            ':location' => $data['location'],
        ])) {
            return self::findById($db, $db->lastInsertId());
        }

        return null;
    }
    public static function findAll(PDO $db): array
    {
        $stmt = $db->query("SELECT * FROM " . self::$table);
        $departments = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $departments[] = new self(
                $row['department_name'],
                $row['location'],
            );
        }
        return $departments;
    }

    public static function findById(PDO $db, int $id): ?Department
    {
        $stmt = $db->prepare("SELECT * FROM " . self::$table . " WHERE department_id = :id");
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return new self(
                $row['department_name'],
                $row['location'],
            );
        }
        return null;
    }

    public static function update(PDO $db, int $id, array $data): bool
    {
        $sql = "UPDATE " . self::$table . " SET 
                department_name = :department_name, 
                location = :location, 
                WHERE department_id = :department_id";

        $stmt = $db->prepare($sql);
        return $stmt->execute([
            ':department_name' => $data['department_name'],
            ':location' => $data['location'],
            ':department_id' => $id
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
                              WHERE department_name LIKE :kw 
                              OR location LIKE :kw ");
        $stmt->execute([':kw' => "%$keyword%"]);

        $departments = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $departments[] = new self(
                $row['department_name'],
                $row['location'],
            );
        }
        return $departments;
    }
}
