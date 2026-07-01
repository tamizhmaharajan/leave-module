<?php
set_include_path(get_include_path() . PATH_SEPARATOR . dirname(__DIR__));
require_once "../repositories/TransactionalRepository.php";

header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] == "GET")
{
    if (!isset($_GET["date"]))
    {
        echo json_encode(["status" => false, "message" => "Date is Required"]);

        exit;
    }
    $transaction_repository = new TransactionalRepository();
    echo json_encode(["status" => true, "data" => $transaction_repository->getTransactionByDate($_GET["date"])]);
}else {
    echo json_encode(["status" => false, "message" => "Invalid Request Method"]);
}