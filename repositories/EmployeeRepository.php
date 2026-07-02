<?php

require_once "config/Database.php";
require_once "models/Employee.php";
require_once "traits/DatabaseTrait.php";

class EmployeeRepository
{
    use DatabaseTrait;

    private mysqli $connection;

    public function __construct()
    {
        $database = new Database();
        $this->connection = $database->getConnection();
    }

    public function loadEmployees(): array
    {
        $employee_master_list = [];

        $query = "SELECT * FROM employee_details";
        $result = $this->getResult($query);

        while ($employee = $result->fetch_assoc()) {
            $employee_master_list[$employee['employee_id']] = new Employee(
                (int) $employee['id'],
                $employee['employee_id'],
                $employee['employee_name'],
                (int) $employee['employee_age'],
                (int) $employee['casual_leave_balance'],
                (int) $employee['medical_leave_balance'],
                (int) $employee['vacation_leave_balance']
            );
        }

        return $employee_master_list;
    }
    public function getEmployeeById(int $_id): ?Employee
    {
        $query = "SELECT * FROM employee_details WHERE id = ?";

        $result = $this->getResult(
            $query,
            "i",
            [$_id]
        );

        $employee = $result->fetch_assoc();

        if (!$employee) {
            return null;
        }

        return new Employee(
            (int) $employee["id"],
            $employee["employee_id"],
            $employee["employee_name"],
            (int) $employee["employee_age"],
            (int) $employee["casual_leave_balance"],
            (int) $employee["medical_leave_balance"],
            (int) $employee["vacation_leave_balance"]
        );
    }
}