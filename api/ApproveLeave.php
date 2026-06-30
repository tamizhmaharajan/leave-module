<?php

require_once "../TransactionalRepository.php";

header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents("php://input"), true);

    if (
        !isset($data["id"]) ||
        !isset($data["manager_approval_status"])
    ) {
        echo json_encode([
            "status" => false,
            "message" => "All Fields are Required"
        ]);
        exit;
    }

    $transaction_repository = new TransactionalRepository();

    $status = $transaction_repository->approveLeave(
        (int) $data["id"],
        (bool) $data["manager_approval_status"]
    );

    if ($status) {
        echo json_encode([
            "status" => true,
            "message" => "Leave Approval Updated Successfully",
            "data" => [
                "transaction_id" => (int) $data["id"],
                "manager_approval_status" => (bool) $data["manager_approval_status"]
            ]
        ]);
    } else {
        echo json_encode([
            "status" => false,
            "message" => "Transaction Not Found"
        ]);
    }
} else {
    echo json_encode([
        "status" => false,
        "message" => "Invalid Request Method"
    ]);
}