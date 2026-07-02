<?php

require_once "services/EmployeeManager.php";
require_once "repositories/TransactionalRepository.php";

class EmployeeController
{
    private EmployeeManager $employee_manager;
    private TransactionalRepository $transaction_repository;

    public function __construct()
    {
        $this->employee_manager = new EmployeeManager();
        $this->transaction_repository = new TransactionalRepository();
    }

    public function getEmployee(): void
    {
        echo json_encode(
            $this->employee_manager->getEmployeeDetails(
                (int)$_GET["id"]
            )
        );
    }

    public function applyLeave(): void
    {
        $data = json_decode(file_get_contents("php://input"), true);

        echo json_encode(
            $this->employee_manager->applyLeave(
                (int)$data["id"],
                (int)$data["leave_days"],
                (int)$data["leave_type_id"]
            )
        );
    }

    public function approveLeave(): void
    {
        $data = json_decode(file_get_contents("php://input"), true);

        $status = $this->transaction_repository->approveLeave(
            (int)$data["id"],
            (bool)$data["manager_approval_status"]
        );

        echo json_encode([
            "status" => $status
        ]);
    }

    public function leaveHistory(): void
    {
        echo json_encode([
            "status" => true,
            "data" => $this->transaction_repository
                ->getEmployeeLeaveHistory((int)$_GET["id"])
        ]);
    }

    public function transactionHistory(): void
    {
        echo json_encode([
            "status" => true,
            "data" => $this->transaction_repository
                ->getTransactionHistory()
        ]);
    }

    public function transactionByDate(): void
    {
        echo json_encode([
            "status" => true,
            "data" => $this->transaction_repository
                ->getTransactionByDate($_GET["date"])
        ]);
    }

    public function leaveTypes(): void
    {
        echo json_encode([
            "status" => true,
            "data" => $this->transaction_repository
                ->getLeaveTypesFromDB()
        ]);
    }
}