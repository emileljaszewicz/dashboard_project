<?php
namespace database;

use PDO;

class MySQLConnect
{
    private $pdoClass;
    public function __construct()
    {
        $this->pdoClass = new PDO('mysql:host=localhost;dbname=dashboard_schema', 'root');
    }
    public function connect(){
        return $this->pdoClass;
    }
}