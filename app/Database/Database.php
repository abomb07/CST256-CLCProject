<?php
namespace App\Database;

use \PDO;

class Database{
   
    
    //getConnection() function to connect database
    function getConnection() {
        // Externalize application database configuration
        // Get credentials for accessing your database
        $servername = config("database.connections.mysql.host");
        $port = config("database.connections.mysql.port");
        $username = config("database.connections.mysql.username");
        $password = config("database.connections.mysql.password");
        $dbname = config("database.connections.mysql.database");
        
        // create connection
        $db = new PDO("mysql:host=$servername;port=$port;dbname=$dbname", $username, $password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $db;
    }
}

?>