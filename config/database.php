<?php

class Database
{
    private $host = "localhost";
    private $username = "root";
    private $password = "";
    private $db_name = "bookdb";

    public $conn;

    public function getConnection() 
    {
        $this->conn = new mysqli($this->host, $this->username, $this->password, $this->db_name);

        // Check connection
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
        return $this->conn;
    }
}
