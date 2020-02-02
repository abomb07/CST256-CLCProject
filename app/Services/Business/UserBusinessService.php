<?php
/* CLC Project version 1.0
 * UserBusinessService version 1.0
 * Adam Bender and Jim Nguyen
 * January 19th, 2020
 * UserBusinessService handles CRUD methods
 */

namespace App\Services\Business;

use \PDO;
use Illuminate\Support\Facades\Log;
use App\Services\Data\UserDataService;
class UserBusinessService{
    
    /* createUser method calls createUser method in UserDataService */
    function createUser($user){
        
        Log::info("Entering SecurityService.createUser()");
        
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
        
        // Create a User Data Service with this connection and insert user information User/
        $dbService = new UserDataService($db);
        $flag = $dbService->createUser($user);
        
        // close the connection
        $db = null;
        
        // return the finder result
        Log::info("Exit UserBusinessService.createUser() with ". $flag);
        return $flag;
    }
    
    /* findUser method calls authenticate method in UserDataService */
    function findUser($credential){
        
        Log::info("Entering SecurityService.findUser()");
        
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
        
        // Create a User Data Service with this connection and try to find the password in User/
        $dbService = new UserDataService($db);
        $flag = $dbService->findUser($credential);
        
        // close the connection
        $db = null;
        
        // return the finder result
        Log::info("Exit UserBusinessService.findUser() with ". $flag);
        return $flag;
    }
    /*
     * function showAllUser (){
     *      Log::info("Entering SecurityService.findUser()");
        
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
        
            // Create a User Data Service with this connection and render all data in User/
            $dbService = new UserDataService($db);
            $flag = $dbService->showAllUser();
        
            // close the connection
            $db = null;
        
            // return the finder result
            Log::info("Exit UserBusinessService.findUser() with ". $flag);
            return $flag;
     * }
     */
    
    /*
     * function findUserByFirstName ($user){
     *      Log::info("Entering SecurityService.findUserByFirstName()");
     
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
     
        // Create a User Data Service with this connection and find user with this firstname in User/
        $dbService = new UserDataService($db);
        $flag = $dbService->findUserByFirstName($user);
     
        // close the connection
        $db = null;
     
        // return the finder result
        Log::info("Exit UserBusinessService.findUserByFirstName() with ". $flag);
        return $flag;
     * }
     */
    
    /*
     * function findUserByLastName ($user){
     *      Log::info("Entering SecurityService.findUserByLastName()");
     
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
     
     // Create a User Data Service with this connection and find user with this last name in User/
     $dbService = new UserDataService($db);
     $flag = $dbService->findUserByLastName($user);
     
     // close the connection
     $db = null;
     
     // return the finder result
     Log::info("Exit UserBusinessService.findUserByLastName() with ". $flag);
     return $flag;
     * }
     */
    
    /*
     * function updateUser ($user){
     *      Log::info("Entering SecurityService.updateUser()");
     
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
     
     // Create a User Data Service with this connection and edit user in User/
     $dbService = new UserDataService($db);
     $flag = $dbService->updateUser($user);
     
     // close the connection
     $db = null;
     
     // return the finder result
     Log::info("Exit UserBusinessService.updateUser() with ". $flag);
     return $flag;
     * }
     */
    
    /*
        function deleteUser ($user){
            Log::info("Entering SecurityService.deleterUser()");
     
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
     
     // Create a User Data Service with this connection , find and delete this user in User/
     $dbService = new UserDataService($db);
     $flag = $dbService->deleteUser($user);
     
     // close the connection
     $db = null;
     
     // return the finder result
     Log::info("Exit UserBusinessService.deleteUser($user) with ". $flag);
     return $flag;
     }
     */
}