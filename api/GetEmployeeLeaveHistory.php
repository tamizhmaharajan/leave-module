<?php

require_once "../TransactionalRepository.php";

header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] == "GET")
{
    if (!isset($_GET["id"]))
    {
        echo json_encode([
            "status" => false,
            "message" => "Employee Id Required"
        ]);
        exit;
    }

    $transaction_repository = new TransactionalRepository();

    echo json_encode([
        "status" => true,
        "data" => $transaction_repository->getEmployeeLeaveHistory(
            (int)$_GET["id"]
        )
    ]);
}
else
{
    echo json_encode([
        "status" => false,
        "message" => "Invalid Request Method"
    ]);
}