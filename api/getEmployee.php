<?php

require_once "../EmployeeManager.php";

header("Content-Type: application/json");
if ($_SERVER["REQUEST_METHOD"] == "GET")
{
    if (!isset($_GET["id"]))
    {
        echo json_encode(["status" => false, "message" => "Employee Id Required"]);
        exit;
    }
    $employee_manager = new EmployeeManager();
    echo json_encode($employee_manager->getEmployeeDetails((int)$_GET["id"]));
}else {
    echo json_encode(["status" => false, "message" => "Invalid Request Method"]);
}