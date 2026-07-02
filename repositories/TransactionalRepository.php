<?php

require_once "config/Database.php";
require_once "models/TransactionalDetails.php";
require_once "traits/DatabaseTrait.php";

class TransactionalRepository
{
    use DatabaseTrait;

    private mysqli $connection;

    public function __construct()
    {
        $database = new Database();
        $this->connection = $database->getConnection();
    }

    /**
     * Load Transaction Details
     * @return array
     */
    public function loadTransactions(): array
    {
        $employee_transactional_list = [];

        $query = "SELECT * FROM save_transactional_details";
        $result = $this->getResult($query);

        while ($transaction = $result->fetch_assoc()) {
            $employee_transactional_list[] = new TransactionalDetails(
                (int) $transaction['id'],
                (int) $transaction['employee_id'],
                (int) $transaction['leave_days'],
                (int) $transaction['leave_type_id'],
                (bool) $transaction['manager_approval_status']
            );
        }

        return $employee_transactional_list;
    }

    /**
     * Save Transaction
     */
    public function saveTransaction(
        int $_employee_id,
        int $_leave_type,
        int $_leave_days,
        bool $_manager_approval_status
    ): void {
        $query = "INSERT INTO save_transactional_details
                  (employee_id, leave_days, leave_type_id, manager_approval_status)
                  VALUES (?, ?, ?, ?)";

        $status = $_manager_approval_status ? 1 : 0;

        $this->executeQuery(
            $query,
            "iiii",
            [$_employee_id, $_leave_days, $_leave_type, $status]
        );
    }

    /**
     * Get Leave Types
     * @return array
     */
    public function getLeaveTypesFromDB(): array
    {
        $leave_types = [];

        $query = "SELECT id, Leave_type_name
                  FROM leave_type
                  ORDER BY id";

        $result = $this->getResult($query);

        while ($row = $result->fetch_assoc()) {
            $leave_types[] = [
                "id" => (int) $row["id"],
                "leave_type_name" => $row["Leave_type_name"]
            ];
        }

        return $leave_types;
    }

    /**
     * Approve Leave
     */
    public function approveLeave(string $_employee_id, bool $_approval_status): bool
    {
        $query = "UPDATE save_transactional_details std
                  INNER JOIN employee_details ed
                  ON std.employee_id = ed.id
                  SET std.manager_approval_status = ?
                  WHERE ed.employee_id = ?";

        $status = $_approval_status ? 1 : 0;

        $statement = $this->executeQuery(
            $query,
            "is",
            [$status, $_employee_id]
        );

        return $statement->affected_rows > 0;
    }

    /**
     * Get Transaction History
     * @return array
     */
    public function getTransactionHistory(): array
    {
        $transaction_history = [];

        $query = "SELECT std.id,
                         ed.employee_id,
                         ed.employee_name,
                         std.leave_days,
                         lt.Leave_type_name,
                         std.manager_approval_status
                  FROM save_transactional_details std
                  INNER JOIN employee_details ed
                          ON std.employee_id = ed.id
                  INNER JOIN leave_type lt
                          ON std.leave_type_id = lt.id
                  ORDER BY std.id";

        $result = $this->getResult($query);

        while ($row = $result->fetch_assoc()) {
            $transaction_history[] = [
                "transaction_id" => (int) $row["id"],
                "employee_id" => $row["employee_id"],
                "employee_name" => $row["employee_name"],
                "leave_days" => (int) $row["leave_days"],
                "leave_type" => $row["Leave_type_name"],
                "manager_approval_status" => (bool) $row["manager_approval_status"]
            ];
        }

        return $transaction_history;
    }

    /**
     * Get Employee Leave History
     * @return array
     */
    public function getEmployeeLeaveHistory(string $_employee_id): array
    {
        $leave_history = [];

        $query = "SELECT std.id,
                         ed.employee_id,
                         ed.employee_name,
                         std.leave_days,
                         lt.Leave_type_name,
                         std.manager_approval_status
                  FROM save_transactional_details std
                  INNER JOIN employee_details ed
                          ON std.employee_id = ed.id
                  INNER JOIN leave_type lt
                          ON std.leave_type_id = lt.id
                  WHERE ed.employee_id = ?
                  ORDER BY std.id";

        $result = $this->getResult(
            $query,
            "s",
            [$_employee_id]
        );

        while ($row = $result->fetch_assoc()) {
            $leave_history[] = [
                "transaction_id" => (int) $row["id"],
                "employee_id" => $row["employee_id"],
                "employee_name" => $row["employee_name"],
                "leave_days" => (int) $row["leave_days"],
                "leave_type" => $row["Leave_type_name"],
                "manager_approval_status" => (bool) $row["manager_approval_status"]
            ];
        }

        return $leave_history;
    }

    /**
     * Get Transaction By Date
     * @return array
     */
    public function getTransactionByDate(string $_date): array
    {
        $transaction_history = [];

        $query = "SELECT std.id,
                         ed.employee_id,
                         ed.employee_name,
                         std.leave_days,
                         lt.Leave_type_name,
                         std.manager_approval_status,
                         std.created_at
                  FROM save_transactional_details std
                  INNER JOIN employee_details ed
                          ON std.employee_id = ed.id
                  INNER JOIN leave_type lt
                          ON std.leave_type_id = lt.id
                  WHERE DATE(std.created_at) = ?";

        $result = $this->getResult(
            $query,
            "s",
            [$_date]
        );

        while ($row = $result->fetch_assoc()) {
            $transaction_history[] = [
                "transaction_id" => (int) $row["id"],
                "employee_id" => $row["employee_id"],
                "employee_name" => $row["employee_name"],
                "leave_days" => (int) $row["leave_days"],
                "leave_type" => $row["Leave_type_name"],
                "manager_approval_status" => (bool) $row["manager_approval_status"],
                "created_at" => $row["created_at"]
            ];
        }

        return $transaction_history;
    }
    
}