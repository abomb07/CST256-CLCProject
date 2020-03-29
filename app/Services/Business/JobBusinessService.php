<?php
/* CLC Project version 5.0
 * JobBusinessService version 5.0
 * Adam Bender and Jim Nguyen
 * March 15, 2020
 * JobBusinessService handles CRUD methods
 */
namespace App\Services\Business;

use App\Database\Database;
use App\Services\Data\JobDataService;
use Illuminate\Support\Facades\Log;
use App\Model\Job;

class JobBusinessService
{
    /**
     * addJob method calls and passes $job to createJob method in JobDataService
     * @param $job
     * @return boolean
     */
    function addJob($job){
        
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
     * editJob method calls and passes $job to updateJob method in JobDataService
     * @param $job
     * @return boolean
     */
    function editJob($job){
        
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
     * findByJobTitle method calls and passes $job to findByTitle method in JobDataService
     * @param $job
     * @return \App\Model\Job
     */
    function findByJobTitle($job){
        
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
     * findByJobDescription method calls and passes $job to findByCategory method in JobDataService
     * @param $job
     * @return \App\Model\Job
     */
    function findByJobDescription($job){
        
        Log::info("Entering JobBusinessService.findByDescription()");
        
        $database = new Database();
        $db = $database->getConnection();
        
        // Create a User Data Service with this connection and calls findByJobDescription method/
        $dbService = new JobDataService($db);
        $flag = $dbService->findByDescription($job);
        
        // close the connection
        $db = null;
        
        // return the finder result
        Log::info("Exit JobBusinessService.findByDescription() with ");
        return $flag;
    }
    
    /**
     * findByJobLocation method calls and passes $job to findByLocation method in JobDataService
     * @param $job
     * @return \App\Model\Job
     */
    function findByJobLocation($job){
        
        Log::info("Entering JobBusinessService.findByLocation()");
        
        $database = new Database();
        $db = $database->getConnection();
        
        // Create a User Data Service with this connection and calls findByJobLocation method/
        $dbService = new JobDataService($db);
        $flag = $dbService->findByLocation($job);
        
        // close the connection
        $db = null;
        
        // return the finder result
        Log::info("Exit JobBusinessService.findByLocation() with ");
        return $flag;
    }
    
    /**
     * findBySkills method calls and passes $job to findBySkills method in JobDataService
     * @param $job
     * @return \App\Model\Job
     */
    function findBySkills($skills){

        Log::info("Entering JobBusinessService.findBySkills()");
        
        $database = new Database();
        $db = $database->getConnection();
        
        // Create a User Data Service with this connection and calls findBySkills method/
        $dbService = new JobDataService($db);
        $flag = $dbService->findBySkills($skills);
        
        // close the connection
        $db = null;
        
        // return the finder result
        Log::info("Exit JobBusinessService.findBySkills() ");
        return $flag;
    }
    
    /**
     * findByEducation method calls and passes $job to findByEducation method in JobDataService
     * @param $job
     * @return \App\Model\Job
     */
    function findByEducation($education){
        
        Log::info("Entering JobBusinessService.findByEducation()");
        
        $database = new Database();
        $db = $database->getConnection();
        
        // Create a User Data Service with this connection and calls findByEducation method/
        $dbService = new JobDataService($db);
        $flag = $dbService->findByEducation($education);
        
        // close the connection
        $db = null;
        
        // return the finder result
        Log::info("Exit JobBusinessService.findByEducation() ");
        return $flag;
    }
    
    /**
     * findByJobHistory method calls and passes $job to findByJobHistory method in JobDataService
     * @param $job
     * @return \App\Model\Job
     */
    function findByJobHistory($jobhistory){
        
        
        
        $database = new Database();
        $db = $database->getConnection();
        
        // Create a User Data Service with this connection and calls findByJobHistory method/
        $dbService = new JobDataService($db);
        $flag = $dbService->findByJobHistory($jobhistory);
        
        // close the connection
        $db = null;
        
        // return the finder result
        Log::info("Exit JobBusinessService.findByJobHistory() ");
        return $flag;
    }
    
    /**
     * jobMatch method calls and passes $job to findBySkills,
     * findByEducation and findByJobHistory method in JobDataService
     * @param $skills, $education, $jobhistory
     * @return \App\Model\Job
     */
    function jobMatch($skills, $education, $jobhistory) 
    {
        Log::info("Entering JobBusinessService.jobMatch()");
        $jobs = array();
        
        //if find skills, calls findBySkills in Job Data Service
        if($skills != null)
        {
            //loops through skills array
            for($i = 0; $i < count($skills); $i++)
            {
                //calls findBySkills 
                $value = $this->findBySkills($skills[$i]['SKILL']);
                if(!in_array($value, $jobs) && $value != null)
                {
                    // merge  jobs into jobs array  
                    $jobs = array_merge($jobs, $value);
                }
            }
        }
        
        //if finds education, calls findByEducation in Job Data Service
        if($education != null)
        {
            //loops through education array
            for($i = 0; $i < count($education); $i++)
            {
                // calls findByEducation
                $value1 = $this->findByEducation($education[$i]['FIELD']);
                if(!in_array($value1, $jobs) && $value1 != null)
                {
                    // merge  jobs into jobs array from previous found jobs 
                    $jobs = array_merge($jobs, $value1);
                }
            }
        }
        
        //if finds jobhistory, calls findByJobHistoryin Job Data Service
        if($jobhistory != null)
        {
            //loops through jobhistory array
            for($i = 0; $i < count($jobhistory); $i++)
            {
                //calls findByJobHistoryin Job Data Service
                $value2 = $this->findByJobHistory($jobhistory[$i]['TITLE']);
                if(!in_array($value2, $jobs) && $value2 != null)
                {
                    // merge  jobs into jobs array from previous found jobs 
                    $jobs = array_merge($jobs, $value2);
                }
            }
        }
        
        $theJobs = array();
        $index = 0;
        for ($i = 0; $i < count($jobs); $i++) 
        {
            $job = new Job($jobs[$i]['ID'], $jobs[$i]['JOB_TITLE'], $jobs[$i]['CATEGORY'], $jobs[$i]['DESCRIPTION'], $jobs[$i]['REQUIREMENTS'], $jobs[$i]['COMPANY'], $jobs[$i]['LOCATION'], $jobs[$i]['SALARY']);
            $theJobs[$index++] = $job;
        }
        
        Log::info("Exit JobBusinessService.jobMatch() ");
        return $theJobs;
    }
}

