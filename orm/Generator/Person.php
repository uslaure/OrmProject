<?php

class Person
{
    protected $tableName;

    public function TableNameBdd()
    {
      return 'person';
    }

    public function GetTable()
    {
      return $this->tableNameBdd = $tableName;
    }

    public function SetTable()
    {
      return $this->tableNameBdd = $tableName;
    }
}
