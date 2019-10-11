<?php
namespace database;

use PDO;

class MySQLConnect
{
    private $pdoClass;
    public function __construct()
    {
        $this->pdoClass = new PDO('mysql:host=localhost;dbname=dashboard_schema;charset=utf8', 'root');
    }
    public function connect(){
        return $this->pdoClass;
    }
}