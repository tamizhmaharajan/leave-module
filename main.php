<?php

require_once "EmployeeManager.php";

/**
 * Main Class
 * Starts the Leave Management System
 */
class Main{
	/**
	 * Constructor
	 * EmployeeManager object and starts the application
	 * @return void
	 */
	public function __construct(){
		$employee_manager_obj = new EmployeeManager();
		$employee_manager_obj->run();
	}
}
$main_obj = new Main();

?>