<?php

set_include_path(get_include_path() . PATH_SEPARATOR . __DIR__);
require_once "services/EmployeeManager.php";


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