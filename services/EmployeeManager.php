<?php

require_once "models/Employee.php";
require_once "models/TransactionalDetails.php";
require_once "LeaveApproval.php";
require_once "LeaveManagerInterface.php";
require_once "repositories/EmployeeRepository.php";
require_once "repositories/TransactionalRepository.php";

class EmployeeManager extends LeaveApproval implements LeaveManagerInterface
{

    private const CASUAL_LEAVE = 1;
    private const MEDICAL_LEAVE = 2;
    private const VACATION_LEAVE = 3;

    private array $employee_master_list = [];
    private array $employee_transactional_list = [];

    private TransactionalRepository $transaction_repository;

    public function __construct()
    {
        $employee_repository = new EmployeeRepository();

        $this->employee_master_list = $employee_repository->loadEmployees();

        $this->transaction_repository = new TransactionalRepository();

        $this->employee_transactional_list = $this->transaction_repository->loadTransactions();
    }

    public function run(): void
    {
        $employee = $this->getEmployee();

        $this->displayUserDetails($employee);

        $leave_days = $this->getLeaveDays();

        $leave_type = $this->getLeaveType();

        $manager_status = $this->managerApproval($employee, $leave_days, $leave_type);

        $this->hrResponse($manager_status);

        $this->transaction_repository->saveTransaction($employee->getId(), $leave_type, $leave_days, $manager_status);
    }
    private function getEmployeeById(string $_id): ?Employee
    {
        return $this->employee_master_list[$_id] ?? null;
    }

    private function validateInput(string $_message, string $_pattern): string
    {
        for ($attempt = 1; $attempt <= 3; $attempt++) {

            $input = trim(readline($_message));

            if (preg_match($_pattern, $input)) {
                return $input;
            }

            echo "Invalid Input\n";
        }

        exit("Maximum Attempts Reached\n");
    }
    private function getEmployee(): Employee
    {
        $employee_id = $this->validateInput(
            "Enter Employee ID : ",
            "/^[1-9][0-9]*$/"
        );

        $employee = $this->getEmployeeById($employee_id);

        if ($employee === null) {
            echo "Employee Not Found\n";
            exit;
        }

        return $employee;
    }
    private function getLeaveDays(): int
    {
        return (int) $this->validateInput(
            "Enter Leave Days : ",
            "/^[1-9][0-9]*$/"
        );
    }
    private function getLeaveType(): int
    {
        echo "\nAvailable Leave Types\n";

        $leave_types = $this->transaction_repository->getLeaveTypesFromDB();

        foreach ($leave_types as $type) {
            echo $type["id"] . "-" . $type["leave_type_name"] . PHP_EOL;
        }

        $valid_id = implode("|", array_column($leave_types, "id"));

        return (int) $this->validateInput(
            "Select Leave Type : ",
            "/^($valid_id)$/"
        );
    }

    private function displayUserDetails(Employee $_employee): void
    {
        echo "\n========== EMPLOYEE DETAILS ==========\n";

        echo "Employee Id : " . $_employee->getEmployeeId() . "\n";
        echo "Employee Name : " . $_employee->getEmployeeName() . "\n";
        echo "Employee Age : " . $_employee->getEmployeeAge() . "\n";

        echo "\n======= LEAVE BALANCE =======\n";

        echo "Casual Leave : " . $_employee->getCasualLeaveBalance() . "\n";
        echo "Medical Leave : " . $_employee->getMedicalLeaveBalance() . "\n";
        echo "Vacation Leave : " . $_employee->getVacationLeaveBalance() . "\n";
    }

    protected function managerApproval(Employee $_employee, int $_leave_days, int $_leave_type): bool
    {

        $balances = [
            self::CASUAL_LEAVE => $_employee->getCasualLeaveBalance(),
            self::MEDICAL_LEAVE => $_employee->getMedicalLeaveBalance(),
            self::VACATION_LEAVE => $_employee->getVacationLeaveBalance()
        ];
        $balance = $balances[$_leave_type];
        $used_days = $this->getUsedLeaveDays($_employee->getId(), $_leave_type);
        $available_balance = $balance - $used_days;

        return $available_balance >= $_leave_days;
    }

    private function hrResponse(bool $_status): void
    {
        if ($_status) {
            echo "\nLeave Granted\n";
        } else {
            echo "\nLeave Rejected\n";
        }
    }
    public function getEmployeeDetails(string $_employee_id): array
    {
        $employee = $this->getEmployeeById($_employee_id);

        if ($employee === null) {
            return ["status" => false, "message" => "Employee Not Found"];
        }

        return [
            "status" => true,
            "data" => [
                "id" => $employee->getId(),
                "employee_id" => $employee->getEmployeeId(),
                "employee_name" => $employee->getEmployeeName(),
                "employee_age" => $employee->getEmployeeAge(),
                "casual_leave_balance" => $employee->getCasualLeaveBalance(),
                "medical_leave_balance" => $employee->getMedicalLeaveBalance(),
                "vacation_leave_balance" => $employee->getVacationLeaveBalance()
            ]
        ];
    }
    public function applyLeave(int $_id, int $_leave_days, int $_leave_type): array
    {
        $employee = $this->getEmployeeById((string) $_id);
        if ($employee == null) {
            return ["status" => false, "message" => "Employee Not Found"];
        }
        $manager_status = $this->managerApproval($employee, $_leave_days, $_leave_type);

        $this->transaction_repository->saveTransaction($employee->getId(), $_leave_type, $_leave_days, $manager_status);

        return [
            "status" => $manager_status,
            "message" => $manager_status ? "Leave Applied Successfully" : "Leave Rejected",
            "data" => [
                "employee_id" => $employee->getId(),
                "employee_name" => $employee->getEmployeeName(),
                "leave_days" => $_leave_days,
                "leave_type_id" => $_leave_type,
                "manager_approval_status" => $manager_status
            ]
        ];
    }
    /**
     * Calculate total approved leave days
     * @param int $_employee_id
     * @param int $_leave_type
     * @return int
     */
    private function getUsedLeaveDays(int $_employee_id, int $_leave_type): int
    {
        $used_days = 0;

        foreach ($this->employee_transactional_list as $transaction) {
            if (
                $transaction->getTdEmployeeId() == $_employee_id &&
                $transaction->getTdLeaveType() == $_leave_type &&
                $transaction->getTdStatus()
            ) {
                $used_days += $transaction->getTdLeaveDays();
            }
        }

        return $used_days;
    }
}
?>