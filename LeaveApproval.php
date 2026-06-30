<?php

abstract class LeaveApproval
{
    abstract protected function managerApproval(Employee $_employee, int $_leave_days, int $_leave_type): bool;
}

?>