<?php

require_once "config/Database.php";
require_once "models/Employee.php";

class EmployeeRepository
{
    private mysqli $connection;

    /**
     * Constructor
     * Get Database Connection
     */
    public function __construct()
    {

        $database = new Database();
        $this->connection = $database->getConnection();
    }

    /**
     * Load all employees from database
     * @return array
     */
    public function loadEmployees(): array
    {
        $employee_master_list = [];

        $result = $this->connection->query("SELECT * FROM employee_details");

        while ($employee = $result->fetch_assoc()) {
            $employee_master_list[$employee['id']] = new Employee(
                $employee['id'],
                $employee['employee_id'],
                $employee['employee_name'],
                $employee['employee_age'],
                $employee['casual_leave_balance'],
                $employee['medical_leave_balance'],
                $employee['vacation_leave_balance']
            );
        }

        return $employee_master_list;
    }
}
?>