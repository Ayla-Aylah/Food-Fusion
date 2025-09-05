<?php

namespace db;

use PDO;
use PDOException;

class Database 
{
    private $dbhost;
    private $dbname;
    private $username;
    private $password;
    protected $db;

    public function __construct($dbhost="localhost", $dbname="foodfusiondb", $username="root", $password="") 
    {
        $this->dbhost = $dbhost;
        $this->dbname = $dbname;
        $this->username = $username;
        $this->password = $password;
    }

    public function connect()
    {
        try {
            $this->db = new PDO("mysql:host=$this->dbhost;dbname=$this->dbname", $this->username, $this->password);
            return $this->db;
            $this->db->exec("SET time_zone = '+06:30'"); // Myanmar = UTC+6:30

        } catch(PDOException $e) {
            return $e->getMessage();
        }
    }
    
}