<?php
/* CLC Project version 6.0
 * JobHistoryBusinessService version 6.0
 * Adam Bender and Jim Nguyen
 * April 5, 2020
 * JobHistoryBusinessService handles CRUD methods
 */
namespace App\Services\Business;

use Illuminate\Support\Facades\Log;
use App\Database\Database;
use App\Services\Data\JobHistoryDataService;

class JobHistoryBusinessService
{
    /**
     * addJobHistory method calls and passes $job to createJobHistory method in JobHistoryDataService
     * @param $job
     * @return boolean
     */
    function addJobHistory($job){
        
        Log::info("Entering JobHistoryBusinessService.addJobHistory()");
        
        // create connection to database
        $database = new Database();
        $db = $database->getConnection();
        
        $dbService = new JobHistoryDataService($db);
        $flag = $dbService->createJobHistory($job);
        
        // close the connection
        $db = null;
        
        // return the finder result
        Log::info("Exit JobHistoryBusinessService.addJobHistory() ");
        return $flag;
    }
    
    /**
     * deleteJobHistory method calls and passes $jobhistory to deleteJobHistory method in JobHistoryDataService
     * @param $job
     * @return boolean
     */
    function deleteJobHistory($job){
        
        Log::info("Entering JobHistoryBusinessService.deleteJob()");
        
        //create connection to database
        $database = new Database();
        $db = $database->getConnection();
        
        // Create a User Data Service with this connection and calls deleteJobHistory method/
        $dbService = new JobHistoryDataService($db);
        $flag = $dbService->deleteJobHistory($job);
        
        // close the connection
        $db = null;
        
        // return the finder result
        Log::info("Exit JobHistoryBusinessService.deleteJobHistory() ");
        return $flag;
    }
    
    /**
     * editJobHistory method calls and passes $job to updateJobHistory method in JobHistoryDataService
     * @param $job
     * @return boolean
     */
    function editJobHistory($job){
        
        Log::info("Entering JobHistoryBusinessService.editJobHistory()");
        
        $database = new Database();
        $db = $database->getConnection();
        
        // Create a User Data Service with this connection and calls updateUser method/
        $dbService = new JobHistoryDataService($db);
        $flag = $dbService->updateJobHistory($job);
        
        // close the connection
        $db = null;
        
        // return the finder result
        Log::info("Exit JobHistoryBusinessService.editJobHistory() ");
        return $flag;
    }
    
    
    /**
     * findById method calls and passes $id to findById method in JobHistoryDataService
     * @param $id
     * @return \App\Model\JobHistory
     */
    function findById($id){
        
        Log::info("Entering JobHistoryBusinessService.findById()");
        
        $database = new Database();
        $db = $database->getConnection();
        
        // Create a Job Data Service with this connection and calls findById method/
        $dbService = new JobHistoryDataService($db);
        $flag = $dbService->findById($id);
        
        // close the connection
        $db = null;
        
        // return the finder result
        Log::info("Exit JobHistoryBusinessService.findById() ");
        return $flag;
    }
    
    /**
     * findJobHistoryByUserId method calls and passes $user_id to findByUserId method in JobHistoryDataService
     * @param $user_id
     * @return array
     */
    function findJobHistoryByUserId($user_id){
        
        Log::info("Entering JobHistoryBusinessService.findJobHistoryByUserId()");
        
        $database = new Database();
        $db = $database->getConnection();
        
        // Create a Job Data Service with this connection and calls findByUserId method/
        $dbService = new JobHistoryDataService($db);
        $flag = $dbService->findByUserId($user_id);
        
        // close the connection
        $db = null;
        
        // return the finder result
        Log::info("Exit JobHistoryBusinessService.findJobHistoryByUserId() ");
        return $flag;
    }
}

