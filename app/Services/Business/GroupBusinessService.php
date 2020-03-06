<?php
/* CLC Project version 3.0
 * JobHistoryBusinessService version 3.0
 * Adam Bender and Jim Nguyen
 * February 23, 2020
 * JobHistoryBusinessService handles CRUD methods
 */

namespace App\Services\Business;

use App\Database\Database;
use App\Services\Data\GroupDataService;
use Illuminate\Support\Facades\Log;

class GroupBusinessService
{
    function createGroup($group){
        Log::info("Entering GroupBusinessService.createGroup()");
        
        // create connection to database
        $database = new Database();
        $db = $database->getConnection();
        
        // Create a Group Data Service with this connection and calls createGroup method/
        $dbService = new GroupDataService($db);
        $flag = $dbService->createGroup($group);
        
        // close the connection
        $db = null;
        
        // return the finder result
        Log::info("Exit GroupBusinessService.createGroup() ");
        return $flag;
    }
    
    /* updateGroup method calls and passes $group to updateGroup method in GroupDataService*/
    function deleteGroup($group){
        
        Log::info("Entering GroupBusinessService.deleteGroup() ");
        
        //create connection to database
        $database = new Database();
        $db = $database->getConnection();
        
        // Create a Group Data Service with this connection and calls deleteGroup method/
        $dbService = new GroupDataService($db);
        $flag = $dbService->deleteGroup($group);
        
        // close the connection
        $db = null;
        
        // return the finder result
        Log::info("Exit GroupBusinessService.deleteGroup() ");
        return $flag;
    }
    
    /* updateGroup method calls and passes $group to updateGroup method in GroupDataService*/
    function updateGroup($group){
        
        Log::info("Entering GroupBusinessService.updateGroup() ");
        
        $database = new Database();
        $db = $database->getConnection();
        
        // Create a Group Data Service with this connection and calls updateGroup method/
        $dbService = new GroupDataService($db);
        $flag = $dbService->updateGroup($group);
        
        // close the connection
        $db = null;
        
        // return the finder result
        Log::info("Exit GroupBusinessService.updateGroup() ");
        return $flag;
    }
    
    /* findAllJobs method calls and passes $job to findAllJobs method in GroupDataService*/
    function findAllGroups(){
        
        Log::info("Entering GroupBusinessService.findAllGroups() ");
        
        $database = new Database();
        $db = $database->getConnection();
        
        // Create a Group Data Service with this connection and calls findAllGroups method/
        $dbService = new GroupDataService($db);
        $flag = $dbService->findAllGroups();
        
        // close the connection
        $db = null;
        
        // return the finder result
        Log::info("Exit GroupBusinessService.findAllGroups() ");
        return $flag;
    }
    /* findById method calls and passes $job to findById method in GroupDataService*/
    function findById($id){
        
        Log::info("Entering GroupBusinessService.findById()");
        
        $database = new Database();
        $db = $database->getConnection();
        
        // Create a Group Data Service with this connection and calls findById method/
        $dbService = new GroupDataService($db);
        $flag = $dbService->findById($id);
        
        // close the connection
        $db = null;
        
        // return the finder result
        Log::info("Exit GroupBusinessService.findById() ");
        return $flag;
    }
}