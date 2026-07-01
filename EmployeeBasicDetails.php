<?php

class EmployeeBasicDetails
{
    protected $employee_id;
    protected $employee_name;
    protected $employee_age;
    /**
     * Initializes the employee with basic details 
     * @param string $_employee_id
     * @param string $_employee_name
     * @param int $_employee_age
     */
    public function __construct(string $_employee_id, string $_employee_name, int $_employee_age) 
    {
        $this->employee_id = $_employee_id;
        $this->employee_name = $_employee_name;
        $this->employee_age = $_employee_age;
    }
    /**
     * get Employee Id
     * @return string
     */ 
    public function getEmployeeId(): string
    {
        return $this->employee_id;
    }
    /**
     * get Employee Name
     * @return string
     */
    public function getEmployeeName(): string
    {
        return $this->employee_name;
    }
    /**
     * get Employee Age
     * @return int
     */
    public function getEmployeeAge(): int
    {
        return $this->employee_age;
    }
}
?>