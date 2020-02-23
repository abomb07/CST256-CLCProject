<?php
/* CLC Project version 2.0
 * UserBusinessService version 2.0
 * Adam Bender and Jim Nguyen
 * February 5, 2020
 * UserBusinessService handles CRUD methods
 */

namespace App\Services\Business;

use App\Database\Database;
use App\Services\Data\UserDataService;
use Illuminate\Support\Facades\Log;
class UserBusinessService{
    
    /* createUser method calls createUser method in UserDataService */
    function createUser($user){
        
        Log::info("Entering SecurityService.createUser()");
        
        // create connection to database
        $database = new Database();
        $db = $database->getConnection();
        
        // Create a User Data Service with this connection and insert user information User/
        $dbService = new UserDataService($db);
        $flag = $dbService->createUser($user);
        
        // close the connection
        $db = null;
        
        // return the finder result
        Log::info("Exit UserBusinessService.createUser() with ". $flag);
        return $flag;
    }
    
    /* checkUser passes $user object checkUSername in UserDataService*/
    function checkUsername ($user){
        
        Log::info("Entering SecurityService.checkUsername()" );
        
        //create connection to database
        $database = new Database();
        $db = $database->getConnection();
        
        
        // Create a User Data Service with this connection and call checkUsername/
        $dbService = new UserDataService($db);
        $flag = $dbService->findUsername($user);
        
        // close the connection
        $db = null;
        
        // return the finder result
        Log::info("Exit UserBusinessService.checkUsername()");
        return $flag;
    }
    
    /* findUser method calls findUser method in UserDataService */
    function findUser($credential){
        
        Log::info("Entering SecurityService.findUser()");
        
        //create connection to database
        $database = new Database();
        $db = $database->getConnection();      
        
        // Create a User Data Service with this connection and passes $credential to findUser in UserDataService/
        $dbService = new UserDataService($db);
        $flag = $dbService->findUser($credential);
        
        // close the connection
        $db = null;
        
        // return the finder result
        Log::info("Exit UserBusinessService.findUser() ");
        return $flag;
    }
    /* checkStatus method calls and passes $user to checkStatus in UserDataService */
    function checkStatus ($user){
        
        Log::info("Entering SecurityService.findById()" );
        
        //create connection to database
        $database = new Database();
        $db = $database->getConnection();
        
        
        // Create a User Data Service with this connection and calls checkStatus/
        $dbService = new UserDataService($db);
        $flag = $dbService->findStatus($user);
        
        // close the connection
        $db = null;
        
        // return the finder result
        Log::info("Exit UserBusinessService.checkStatus()");
        return $flag;
    }
    
    /* updateUser method calls and passes $user to updateUser method in UserDataService*/
    function updateUser($user){
        
        Log::info("Entering SecurityService.updateUser()");
        
        $database = new Database();
        $db = $database->getConnection();
        
        // Create a User Data Service with this connection and calls updateUser method/
        $dbService = new UserDataService($db);
        $flag = $dbService->updateUser($user);
        
        // close the connection
        $db = null;
        
        // return the finder result
        Log::info("Exit UserBusinessService.updateUser() with ". $flag);
        return $flag;
    }
    /* deleteUser method calls and passes $user to deleteUser method in UserDataService */
    function deleteUser($user){
        
        Log::info("Entering SecurityService.deleteUser()");
        
        //create connection to database
        $database = new Database();
        $db = $database->getConnection();
        
        // Create a User Data Service with this connection and calls deleteUser method/
        $dbService = new UserDataService($db);
        $flag = $dbService->deleteUser($user);
        
        // close the connection
        $db = null;
        
        // return the finder result
        Log::info("Exit UserBusinessService.deleteUser() with ". $flag);
        return $flag;
    }
    
    /* showAllUser method calls showAllUsers method in UserDataService */
    function findAllUser (){
        
        Log::info("Entering SecurityService.showAllUser()");
        
        //create connection to database
        $database = new Database();
        $db = $database->getConnection();
        
        // Create a User Data Service with this connection and calls showAllUser method/
        $dbService = new UserDataService($db);
        $flag = $dbService->findAllUser();
        
        // close the connection
        $db = null;
        
        // return the finder result
        Log::info("Exit UserBusinessService.showAllUser()");
        return $flag;
    }
    
    /* findById method calls and passes $user to findById method in UserDataService */
    function findById ($id){
        Log::info("Entering SecurityService.findById() with " .$id);
        
        //create connection to database
        $database = new Database();
        $db = $database->getConnection();
             
        // Create a User Data Service with this connection and calls findById method/
        $dbService = new UserDataService($db);
        $flag = $dbService->findById($id);
        
        // close the connection
        $db = null;
        
        // return the finder result
        Log::info("Exit UserBusinessService.findById()");
        return $flag;
    }
    
    /* suspendUser method calls and passes $user to suspendUser method in UserDataService */
    function suspendUser ($user){
        
        Log::info("Entering SecurityService.suspendUser() ");
        
        //create connection to database
        $database = new Database();
        $db = $database->getConnection();
        
        // Create a User Data Service with this connection and calls suspendUser method/
        $dbService = new UserDataService($db);
        
        $user->setStatus("suspended");
        $flag = $dbService->updateUser($user);
        
        // close the connection
        $db = null;
        
        // return the finder result
        Log::info("Exit UserBusinessService.suspendUser()");
        return $flag;
    }
    
    /* suspendUser method calls and passes $user to suspendUser method in UserDataService */
    function activateUser ($user){
        
        Log::info("Entering SecurityService.activateUser() ");
        
        //create connection to database
        $database = new Database();
        $db = $database->getConnection();
        
        // Create a User Data Service with this connection and calls suspendUser method/
        $dbService = new UserDataService($db);
        
        $user->setStatus("active");
        $flag = $dbService->updateUser($user);
        
        // close the connection
        $db = null;
        
        // return the finder result
        Log::info("Exit UserBusinessService.activateUser()");
        return $flag;
    }
    
    /* findUserByFirstName method calls and passes $user to findByFirstName method in UserDataService */
    function findByFirstName ($user){
        
        Log::info("Entering SecurityService.findUserByFirstName()");
        
        //create connection to database
        $database = new Database();
        $db = $database->getConnection();
        
        // Create a User Data Service with this connection and insert user information User/
        $dbService = new UserDataService($db);
        $flag = $dbService->findByFirstName($user);
        
        // close the connection
        $db = null;
        
        // return the finder result
        Log::info("Exit UserBusinessService.findUserByFirstName()");
        return $flag;
    }
    
    /* findByLastName method calls and passes $user to findByLastName method in UserDataService */
    function findByLastName ($user){
        
        Log::info("Entering SecurityService.findUserByLastName()");
        
        //create connection to database
        $database = new Database();
        $db = $database->getConnection();
        
        // Create a User Data Service with this connection and calls findByLastName method/
        $dbService = new UserDataService($db);
        $flag = $dbService->findByLastName($user);
        
        // close the connection
        $db = null;
        
        // return the finder result
        Log::info("Exit UserBusinessService.findUserByLastName()");
        return $flag;
    }
    
}