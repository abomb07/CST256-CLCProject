<?php
namespace App\Services\Business;

use Illuminate\Support\Facades\Log;
use App\Database\Database;
use App\Services\Data\JobHistoryDataService;

class JobHistoryBusinessService
{
    function createJobHistory($job){
        
        Log::info("Entering JobHistoryBusinessService.createJobHistory()");
        
        // create connection to database
        $database = new Database();
        $db = $database->getConnection();
        
        $dbService = new JobHistoryDataService($db);
        $flag = $dbService->createJobHistory($job);
        
        // close the connection
        $db = null;
        
        // return the finder result
        Log::info("Exit JobHistoryBusinessService.createJobHistory() ");
        return $flag;
    }
    
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
    
    /* updateJobHistory method calls and passes $job to updateJob method in UserDataService*/
    function updateJobHistory($job){
        
        Log::info("Entering JobHistoryBusinessService.updateJobHistory()");
        
        $database = new Database();
        $db = $database->getConnection();
        
        // Create a User Data Service with this connection and calls updateUser method/
        $dbService = new JobHistoryDataService($db);
        $flag = $dbService->updateJobHistory($job);
        
        // close the connection
        $db = null;
        
        // return the finder result
        Log::info("Exit JobHistoryBusinessService.updateJobHistory() ");
        return $flag;
    }
    
    /* findAllJobs method calls and passes $job to findAllJobs method in UserDataService*/
    function findAllJobs(){
        
        Log::info("Entering JobHistoryBusinessService.fidnAllJobHisotry()");
        
        $database = new Database();
        $db = $database->getConnection();
        
        // Create a User Data Service with this connection and calls findAllJobs method/
        $dbService = new JobHistoryDataService($db);
        $flag = $dbService->findAllJobs();
        
        // close the connection
        $db = null;
        
        // return the finder result
        Log::info("Exit JobHistoryBusinessService.fidnAllJobHisotry() ");
        return $flag;
    }
    /* findById method calls and passes $job to findById method in UserDataService*/
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
    
    /* findByUserId method calls and passes $job to findByUserId method in UserDataService*/
    function findByUserId($user_id){
        
        Log::info("Entering JobHistoryBusinessService.findByUserId()");
        
        $database = new Database();
        $db = $database->getConnection();
        
        // Create a Job Data Service with this connection and calls findByUserId method/
        $dbService = new JobHistoryDataService($db);
        $flag = $dbService->findByUserId($user_id);
        
        // close the connection
        $db = null;
        
        // return the finder result
        Log::info("Exit JobHistoryBusinessService.findByUserId() ");
        return $flag;
    }
    
    
    
    
}

