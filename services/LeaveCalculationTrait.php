<?php

trait LeaveCalculationTrait
{
    /**
     * Calculate total approved leave days
     * @param int $_id
     * @param int $_leave_type
     * @return int
     */
    private function getUsedLeaveDays(int $_id, int $_leave_type): int
    {
        $used_days = 0;
        foreach ($this->employee_transactional_list as $transaction)
        {
            if ($transaction->getTdId() == $_id && $transaction->getTdLeaveType() == $_leave_type && $transaction->getTdStatus()) 
            {
                $used_days += $transaction->getTdLeaveDays();
            }
        }

        return $used_days;
    }
}