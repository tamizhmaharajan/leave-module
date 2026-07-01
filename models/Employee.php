<?php

require_once "EmployeeBasicDetails.php";

class Employee extends EmployeeBasicDetails
{
    private $id;
    private $casual_leave_balance;
    private $medical_leave_balance;
    private $vacation_leave_balance;
    /**
     * Initializes the employee with basic details and leave balances
     * @param int $_id
     * @param string $_employee_id
     * @param string $_employee_name
     * @param int $_employee_age
     * @param int $_casual_leave_balance
     * @param int $_medical_leave_balance
     * @param int $_vacation_leave_balance
     */
    public function __construct(int $_id, string $_employee_id, string $_employee_name, int $_employee_age, int $_casual_leave_balance, int $_medical_leave_balance, int $_vacation_leave_balance)
	{
        $this->id = $_id;
        parent::__construct($_employee_id, $_employee_name, $_employee_age);
        $this->casual_leave_balance = $_casual_leave_balance;
        $this->medical_leave_balance = $_medical_leave_balance;
        $this->vacation_leave_balance = $_vacation_leave_balance;
    }
    public function getId(): int
    {
        return $this->id;
    }
    /**
     * get casual leave balance
     * return int
     */

    public function getCasualLeaveBalance(): int
    {
        return $this->casual_leave_balance;
    }
    /**
     * get Medical Leave Balance
     * @return int
     */
    public function getMedicalLeaveBalance(): int
    {
        return $this->medical_leave_balance;
    }
    /**
     * get Vacation Leave Balance
     * @return int
     */
    public function getVacationLeaveBalance(): int
    {
        return $this->vacation_leave_balance;
    }
}
?>