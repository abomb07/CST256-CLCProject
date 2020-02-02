<?php
namespace App\Database;

use \mysqli;

class Database{
    
    private $servername = "localhost";
    private $username = "root";
    private $password = "root";
    private $database_name = "CST256-CLCProject";
    
    //getConnection() function to connect database
    function getConnection() {
        
        
        $connection = mysqli_connect($this->servername, $this->username, $this->password, $this->database_name);
        
        
        if (!$connection) {
            die("Connection failed: " . mysqli_connect_error());
        }else{
            //echo "Connected successfully";
        }
        return $connection;
    }
}

?>