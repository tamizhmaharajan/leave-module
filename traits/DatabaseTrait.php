<?php

trait DatabaseTrait
{
    protected function executeQuery(string $_query, string $_types = "", array $_params = []): mysqli_stmt
    {
        $statement = $this->connection->prepare($_query);

        if (!$statement) 
        {
            throw new Exception($this->connection->error);
        }

        if ($_types !== "") 
        {
            $statement->bind_param($_types, ...$_params);
        }

        $statement->execute();

        return $statement;
    }
    protected function getResult(string $_query, string $_types = "", array $_params = []): mysqli_result
    {
        return $this->executeQuery($_query, $_types, $_params)->get_result();
    }

}