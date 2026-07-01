<?php
set_include_path(get_include_path() . PATH_SEPARATOR . dirname(__DIR__));
require_once "../repositories/TransactionalRepository.php";

header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] == "GET")
{
    if (!isset($_GET["id"]))
    {
        echo json_encode(["status" => false, "message" => "Employee Id Required"]);

        exit;
    }
    $transaction_repository = new TransactionalRepository();
    echo json_encode(["status" => true,"data" => $transaction_repository->getEmployeeLeaveHistory((int)$_GET["id"] )]);
}else {
    echo json_encode([ "status" => false, "message" => "Invalid Request Method"]);
}