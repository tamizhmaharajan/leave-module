<?php
set_include_path(get_include_path() . PATH_SEPARATOR . dirname(__DIR__));
require_once "../repositories/TransactionalRepository.php";

header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] == "GET")
{
    $transaction_repository = new TransactionalRepository();
    echo json_encode([ "status" => true, "data" => $transaction_repository->getLeaveTypesFromDB()]);
}else {
    echo json_encode([ "status" => false, "message" => "Invalid Request Method"]);
}
?>