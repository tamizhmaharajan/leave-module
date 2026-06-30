<?php
class TransactionalDetails
{
    private int $employee_id;
    private int $leave_days;
    private int $leave_type;
    private bool $manager_approval_status;

    public function __construct(
        int $employee_id,
        int $leave_days,
        int $leave_type,
        bool $manager_approval_status
    ) {
        $this->employee_id = $employee_id;
        $this->leave_days = $leave_days;
        $this->leave_type = $leave_type;
        $this->manager_approval_status = $manager_approval_status;
    }

    public function getTdEmployeeId(): int
    {
        return $this->employee_id;
    }

    public function getTdLeaveDays(): int
    {
        return $this->leave_days;
    }

    public function getTdLeaveType(): int
    {
        return $this->leave_type;
    }

    public function getTdStatus(): bool
    {
        return $this->manager_approval_status;
    }
}
?>