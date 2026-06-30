<?php

$host = 'localhost';
$user = 'root';
$pass = 'tamizh';
$db = 'leave_management';



mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try{
    $connect = new mysqli('localhost', 'root', 'tamizh', 'leave_management');
    echo "Success! Connected via mysqli.";
}catch(mysqli_sql_exception $e){
    echo "Database Connection failed";
}
?>