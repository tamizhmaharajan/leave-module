<?php

require_once "../TransactionalRepository.php";

header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] == "GET")
{
    $transaction_repository = new TransactionalRepository();

    echo json_encode([
        "status" => true,
        "data" => $transaction_repository->getLeaveTypesFromDB()
    ]);
}
else
{
    echo json_encode([
        "status" => false,
        "message" => "Invalid Request Method"
    ]);
}