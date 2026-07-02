<?php

trait DatabaseTrait
{
    protected function executeQuery(string $_query, string $_types = "", array $_params = []): mysqli_stmt
    {
        $statement = $this->connection->prepare($_query);

        if ($_types !== "") {
            $statement->bind_param($_types, ...$_params);
        }

        $statement->execute();

        return $statement;
    }

    protected function fetchAll(string $_query): mysqli_result
    {
        return $this->connection->query($_query);
    }
}