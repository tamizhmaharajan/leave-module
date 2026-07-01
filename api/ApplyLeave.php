<?php
set_include_path(get_include_path() . PATH_SEPARATOR . dirname(__DIR__));
require_once "../services/EmployeeManager.php";

header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    $data = json_decode(file_get_contents("php://input"), true);
    if (!isset($data["id"]) || !isset($data["leave_days"]) || !isset($data["leave_type_id"]))
    {
        echo json_encode(["status" => false, "message" => "All Fields are Required"]);

        exit;
    }
    $employee_manager = new EmployeeManager();
    echo json_encode($employee_manager->applyLeave((int)$data["id"], (int)$data["leave_days"], (int)$data["leave_type_id"] ) );
}else {
    echo json_encode([ "status" => false, "message" => "Invalid Request Method"]);
}