<?php

require_once "Router.php";
require_once "controllers/EmployeeController.php";

$method = $_SERVER["REQUEST_METHOD"];
$path = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);

$controller = new EmployeeController();

$router = new Router();

$router->add(
    "GET",
    "/employee",
    [$controller, "getEmployee"]
);

$router->add(
    "POST",
    "/applyLeave",
    [$controller, "applyLeave"]
);

$router->add(
    "POST",
    "/approveLeave",
    [$controller, "approveLeave"]
);

$router->add(
    "GET",
    "/leaveHistory",
    [$controller, "leaveHistory"]
);

$router->add(
    "GET",
    "/transactionHistory",
    [$controller, "transactionHistory"]
);

$router->add(
    "GET",
    "/transactionByDate",
    [$controller, "transactionByDate"]
);

$router->add(
    "GET",
    "/leaveTypes",
    [$controller, "leaveTypes"]
);

$router->dispatch($method, $path);