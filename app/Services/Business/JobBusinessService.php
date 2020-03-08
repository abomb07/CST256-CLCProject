<?php
/* CLC Project version 3.0
 * JobBusinessService version 3.0
 * Adam Bender and Jim Nguyen
 * February 23, 2020
 * JobBusinessService handles CRUD methods
 */
namespace App\Services\Business;

use App\Database\Database;
use App\Services\Data\JobDataService;
use Illuminate\Support\Facades\Log;

class JobBusinessService
{
    /**
     * createJob method calls and passes $job to createJob method in JobDataService
     * @param $job
     * @return boolean
     */
    function createJob($job){
        
        Log::info("Entering JobBusinessService.createUser()");
        
        // create connection to database
        $database = new Database();
        $db = $database->getConnection();
        
        $dbService = new JobDataService($db);
        $flag = $dbService->createJob($job);
        
        // close the connection
        $db = null;
        
        // return the finder result
        Log::info("Exit JobBusinessService.createUser() with ");
        return $flag;
    }
    
    /**
     * deleteJob method calls and passes $job to deleteJob method in JobDataService
     * @param $job
     * @return boolean
     */
    function deleteJob($job){
        
        Log::info("Entering JobBusinessService.deleteJob()");
        
        //create connection to database
        $database = new Database();
        $db = $database->getConnection();
        
        // Create a User Data Service with this connection and calls deleteJob method/
        $dbService = new JobDataService($db);
        $flag = $dbService->deleteJob($job);
        
        // close the connection
        $db = null;
        
        // return the finder result
        Log::info("Exit JobBusinessService.deleteJob() with ");
        return $flag;
    }
    
    /**
     * updateJob method calls and passes $job to updateJob method in JobDataService
     * @param $job
     * @return boolean
     */
    function updateJob($job){
        
        Log::info("Entering JobBusinessService.updateUser()");
        
        $database = new Database();
        $db = $database->getConnection();
        
        // Create a User Data Service with this connection and calls updateUser method/
        $dbService = new JobDataService($db);
        $flag = $dbService->updateJob($job);
        
        // close the connection
        $db = null;
        
        // return the finder result
        Log::info("Exit JobBusinessService.updateUser() with ");
        return $flag;
    }
    
    /**
     * findAllJobs method calls findAllJobs method in JobDataService
     * @return array
     */
    function findAllJobs(){
        
        Log::info("Entering JobBusinessService.findAllJobs()");
        
        $database = new Database();
        $db = $database->getConnection();
        
        // Create a User Data Service with this connection and calls findAllJobs method/
        $dbService = new JobDataService($db);
        $flag = $dbService->findAllJobs();
        
        // close the connection
        $db = null;
        
        // return the finder result
        Log::info("Exit JobBusinessService.findAllJobs() with ");
        return $flag;
    }
    
    /**
     * findById method calls and passes $id to findById method in JobDataService
     * @param $id
     * @return \App\Model\Job
     */
    function findById($id){
        
        Log::info("Entering JobBusinessService.findById()");
        
        $database = new Database();
        $db = $database->getConnection();
        
        // Create a Job Data Service with this connection and calls findById method/
        $dbService = new JobDataService($db);
        $flag = $dbService->findById($id);
        
        // close the connection
        $db = null;
        
        // return the finder result
        Log::info("Exit JobBusinessService.findById() with ");
        return $flag;
    }
    
    /**
     * findByTitle method calls and passes $job to findByTitle method in JobDataService
     * @param $job
     * @return \App\Model\Job
     */
    function findByTitle($job){
        
        Log::info("Entering JobBusinessService.findById()");
        
        $database = new Database();
        $db = $database->getConnection();
        
        // Create a User Data Service with this connection and calls findByTitle method/
        $dbService = new JobDataService($db);
        $flag = $dbService->findByTitle($job);
        
        // close the connection
        $db = null;
        
        // return the finder result
        Log::info("Exit JobBusinessService.findByTitle() with ");
        return $flag;
    }
    
    /**
     * findByCategory method calls and passes $job to findByCategory method in JobDataService
     * @param $job
     * @return \App\Model\Job
     */
    function findByCategory($job){
        
        Log::info("Entering JobBusinessService.findByCategory()");
        
        $database = new Database();
        $db = $database->getConnection();
        
        // Create a User Data Service with this connection and calls findByCategory method/
        $dbService = new JobDataService($db);
        $flag = $dbService->findByCategory($job);
        
        // close the connection
        $db = null;
        
        // return the finder result
        Log::info("Exit JobBusinessService.findByCategory() with ");
        return $flag;
    }
    
    /**
     * findByLocation method calls and passes $job to findByLocation method in JobDataService
     * @param $job
     * @return \App\Model\Job
     */
    function findByLocation($job){
        
        Log::info("Entering JobBusinessService.findByLocation()");
        
        $database = new Database();
        $db = $database->getConnection();
        
        // Create a User Data Service with this connection and calls updateUser method/
        $dbService = new JobDataService($db);
        $flag = $dbService->findByLocation($job);
        
        // close the connection
        $db = null;
        
        // return the finder result
        Log::info("Exit JobBusinessService.findByLocation() with ");
        return $flag;
    }
    
}

