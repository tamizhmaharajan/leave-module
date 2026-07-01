<?php
class Database
{
    private $connection;

    public function __construct()
    {
        $this->connection = new mysqli("127.0.0.1", "root", "tamizh", "leave_management");

    }

    public function getConnection(): mysqli
    {
        return $this->connection;
    }
}
?>