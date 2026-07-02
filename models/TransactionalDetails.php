<?php
class TransactionalDetails
{
    private int $id;
    private int $employee_id;
    private int $leave_days;
    private int $leave_type;
    private bool $manager_approval_status;

    public function __construct(int $_id,int $_employee_id, int $_leave_days, int $_leave_type,bool $_manager_approval_status) 
    {
        $this->id = $_id;
        $this->employee_id = $_employee_id;
        $this->leave_days = $_leave_days;
        $this->leave_type = $_leave_type;
        $this->manager_approval_status = $_manager_approval_status;
    }
    public function getTdId(): int
    {
        return $this->getTdId();
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