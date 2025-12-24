<?php

require_once 'Displayable.php';
require_once __DIR__ . '/../Validator.php';

class Department implements Displayable
{
    private $departmentName;
    private $location;
    protected $validator;


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
}
