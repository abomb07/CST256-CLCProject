<?php
/* CLC Project version 5.0
 * JobDataService version 5.0
 * Adam Bender and Jim Nguyen
 * March 15, 2020
 * JobDataService handle methods through MySQL Statement
 */
namespace App\Services\Data;

use PDO;
use PDOException;
use Illuminate\Support\Facades\Log;
use App\Services\Utility\DatabaseException;

use App\Model\Job;

class JobDataService
{
    private $connection = NULL;
    
    /**
     * Non default constructor handles db connection
     * @param $connection
     */
    public function __construct($connection){
        $this->connection = $connection;
    }
    
    /**
     * createJob method connects to database and add new job information into SQL statement
     * @param Job $job
     * @throws DatabaseException
     * @return boolean
     */
    function createJob(Job $job){
        Log::info("Entering JobDataService::createJob()");
        try{
            // Insert job information into Job table
            $statement = $this->connection->prepare("INSERT INTO JOB (JOB_TITLE, CATEGORY, DESCRIPTION, REQUIREMENTS, COMPANY, LOCATION, SALARY) VALUES ( :jobtitle, :category, :description, :requirements, :company, :location, :salary)");
            
            
            // if the statement goes wrong return error message
            if(!$statement){
                echo "Something wrong in the binding process.sql error?";
                exit;
            }
            
            $jobtitle = $job->getJobtitle();
            $category = $job->getCategory();
            $description = $job->getDescription();
            $requirements = $job->getRequirements();
            $company = $job->getCompany();
            $location = $job->getLocation();
            $salary = $job->getSalary();
            
            $statement->bindParam(':jobtitle', $jobtitle, PDO::PARAM_STR);
            $statement->bindParam(':category', $category, PDO::PARAM_STR);
            $statement->bindParam(':description', $description, PDO::PARAM_STR);
            $statement->bindParam(':requirements', $requirements, PDO::PARAM_STR);
            $statement->bindParam(':company', $company, PDO::PARAM_STR);
            $statement->bindParam(':location',  $location, PDO::PARAM_STR);
            $statement->bindParam(':salary',  $salary, PDO::PARAM_STR);
            $statement->execute();
            
            // if statement succeses return true, else return false
            if($statement->rowCount() > 0){
                
                Log::info("Exit JobDataService.createJob with true");
                return true;
                
            }else{
                Log::info("Exit JobDataService.createJob with false");
                return false;
            }
        }catch(PDOException $e)
        {
            // catch exception and throw DatabaseException
            Log::error("Exception: ", array("message " => $e->getMessage()));
            throw new DatabaseException("Database Exception: ". $e->getMessage(), 0, $e);
        }
    }
    
    /**
     * deleteJob method connects database and delete job using MySQL statement
     * @param Job $job
     * @throws DatabaseException
     * @return boolean
     */
    function deleteJob(Job $job){
        Log::info("Entering JobDataService::deleteJob()");
        try{
            $statement = $this->connection->prepare("DELETE FROM JOB WHERE ID = :id");
            
            // if the statement goes wrong return error message
            if(!$statement){
                echo "Something wrong in the binding process.sql error?";
                exit;
            }
            
            $id = $job->getId();
            $statement->bindParam(':id',  $id, PDO::PARAM_INT) ;
            $statement->execute();
            
            if($statement->rowCount() > 0){
                
                Log::info("Exit JobDataService.deleteJob with true");
                return true;
                
            }else{
                Log::info("Exit JobDataService.deleJob with false");
                return false;
            }
        }catch(PDOException $e)
        {
            // catch exception and throw DatabaseException
            Log::error("Exception: ", array("message " => $e->getMessage()));
            throw new DatabaseException("Database Exception: ". $e->getMessage(), 0, $e);
        }
    }
    
    /**
     * updateJob method render data and update job information in database
     * @param Job $job
     * @throws DatabaseException
     * @return boolean
     */
    function updateJob(Job $job)
    {
        Log::info("Entering SecurityDAO::updateJob()");
        
        try{
            //update user information in database
            $statement = $this->connection->prepare("UPDATE JOB SET ID = :id, JOB_TITLE = :jobtitle, CATEGORY = :category, DESCRIPTION = :description, REQUIREMENTS = :requirements, COMPANY = :company, LOCATION = :location, SALARY = :salary WHERE ID = :id");
            
            // if the statement goes wrong return error message
            if(!$statement){
                echo "Something wrong in the binding process.sql error?";
                exit;
            }
            
            $id = $job->getId();
            $jobtitle = $job->getJobtitle();
            $category = $job->getCategory();
            $description = $job->getDescription();
            $requirements = $job->getRequirements();
            $company = $job->getCompany();
            $location = $job->getLocation();
            $salary = $job->getSalary();
            
            $statement->bindParam(':id', $id, PDO::PARAM_STR);
            $statement->bindParam(':jobtitle', $jobtitle, PDO::PARAM_STR);
            $statement->bindParam(':category', $category, PDO::PARAM_STR);
            $statement->bindParam(':description', $description, PDO::PARAM_STR);
            $statement->bindParam(':requirements', $requirements, PDO::PARAM_STR);
            $statement->bindParam(':company', $company, PDO::PARAM_STR);
            $statement->bindParam(':location',  $location, PDO::PARAM_STR);
            $statement->bindParam(':salary',  $salary, PDO::PARAM_STR);
            $statement->execute();
            
            //if statement executes successfully returns true, else returns false
            if($statement->rowCount() > 0){
                Log::info("Exit JobDataService.updateJob with true");
                return true;
                
            }else{
                Log::info("Exit JobDataService.updateJob with false");
                return false;
            }
            
        }catch(PDOException $e)
        {
            // catch exception and throw DatabaseException
            Log::error("Exception: ", array("message " => $e->getMessage()));
            throw new DatabaseException("Database Exception: ". $e->getMessage(), 0, $e);
        }
    }
    
    /**
     * findAllJobs method returns all jobs exist in database
     * @throws DatabaseException
     * @return array
     */
    function findAllJobs(){
        Log::info("Entering SecurityDAO::findAllJob()");
        
        try{
            // Select all jobs in database
            $statement = $this->connection->prepare("SELECT * FROM JOB");
            
            
            // if the statement goes wrong return error message
            if(!$statement){
                echo "Something wrong in the binding process.sql error?";
                exit;
            }
            
            //execute statement
            $statement->execute();
            
            //if statement execute successfully return $users
            if($statement->rowCount() > 0){
                
                Log::info("Exit SecurityDAO.findAllJobs with true");
                
                $index = 0;
                $jobs = array();
                
                while($row = $statement->fetch(PDO::FETCH_ASSOC))
                {
                    $job = new Job($row['ID'], $row['JOB_TITLE'], $row['CATEGORY'], $row['DESCRIPTION'], $row['REQUIREMENTS'], $row['COMPANY'], $row['LOCATION'], $row['SALARY']);
                    $jobs[$index++] = $job;
                }
                return $jobs;
            }
            
        }
        catch(PDOException $e)
        {
            // catch exception and throw DatabaseException
            Log::error("Exception: ", array("message " => $e->getMessage()));
            throw new DatabaseException("Database Exception: ". $e->getMessage(), 0, $e);
        }
    }
    
    /**
     * findById method find job with matched id in database
     * @param $id
     * @throws DatabaseException
     * @return \App\Model\Job
     */
    function findById($id){
        Log::info("Entering SecurityDAO::findById()");
        
        try{
            
            // find job information by given id in database
            $statement = $this->connection->prepare("SELECT ID, JOB_TITLE, CATEGORY, DESCRIPTION, REQUIREMENTS, COMPANY, LOCATION, SALARY FROM JOB WHERE ID = :id ");
            
            
            // if the statement goes wrong return error message
            if(!$statement){
                echo "Something wrong in the binding process.sql error?";
                exit;
            }
            //bindParam $id
            $statement->bindParam(':id', $id);
            $statement->execute();
            
            if($statement->rowCount() == 1){
                Log::info("Exit SecurityDAO.findById");
                
                //fetches user from database and returns $user
                $row = $statement->fetch(PDO::FETCH_ASSOC);
                $result = new Job($row['ID'],$row['JOB_TITLE'], $row['CATEGORY'], $row['DESCRIPTION'], $row['REQUIREMENTS'], $row['COMPANY'], $row['LOCATION'], $row['SALARY']);
                
                //return  found results
                return $result;
            }
            
        }catch(PDOException $e)
        {
            // catch exception and throw DatabaseException
            Log::error("Exception: ", array("message " => $e->getMessage()));
            throw new DatabaseException("Database Exception: ". $e->getMessage(), 0, $e);
        }
    }
    
    /**
     * findbyTitle method finds for job with entered title
     * @param Job $job
     * @throws DatabaseException
     * @return array
     */
    function findByTitle(Job $job){
        Log::info("Entering SecurityDAO::findByTitle()");
        
        try{
            $jobtitle = $job->getJobtitle();
            $statement = $this->connection->prepare("SELECT ID, JOB_TITLE, CATEGORY, DESCRIPTION, REQUIREMENTS, COMPANY, LOCATION, SALARY FROM JOB WHERE JOB_TITLE LIKE CONCAT('%', :jobtitle, '%') ");
            
            // if the statement goes wrong return error message
            if(!$statement){
                echo "Something wrong in the binding process.sql error?";
                exit;
            }
            
            //bindParam lastname and executes statement
            $statement->bindParam(':jobtitle', $jobtitle);
            $statement->execute();
            
            //if statement executes successfully
            if($statement->rowCount() > 0){
                Log::info("Exit SecurityDAO.findByTitle() ");
                
                //fetching users from database
                $jobs = $statement->fetchAll();
                
                //return users object
                return $jobs;
            }
            
        }catch(PDOException $e)
        {
            // catch exception and throw DatabaseException
            Log::error("Exception: ", array("message " => $e->getMessage()));
            throw new DatabaseException("Database Exception: ". $e->getMessage(), 0, $e);
        }
    }  
    
    /**
     * findByLocation method finds for job with entered location
     * @param Job $job
     * @throws DatabaseException
     * @return array
     */
    function findByLocation(Job $job){
        Log::info("Entering SecurityDAO::findByLocation()");
        
        try{
            $location = $job->getLocation();
            $statement = $this->connection->prepare("SELECT ID, JOB_TITLE, CATEGORY, DESCRIPTION, REQUIREMENTS, COMPANY, LOCATION, SALARY FROM JOB WHERE LOCATION LIKE CONCAT('%', :location, '%') ");
            
            // if the statement goes wrong return error message
            if(!$statement){
                echo "Something wrong in the binding process.sql error?";
                exit;
            }
            
            //bindParam lastname and executes statement
            $statement->bindParam(':location', $location);
            $statement->execute();
            
            //if statement executes successfully
            if($statement->rowCount() > 0){
                Log::info("Exit SecurityDAO.findByLocation() ");
                
                //fetching users from database
                $jobs = $statement->fetchAll();
                
                //return jobs object
                return $jobs;
            }
            
        }catch(PDOException $e)
        {
            // catch exception and throw DatabaseException
            Log::error("Exception: ", array("message " => $e->getMessage()));
            throw new DatabaseException("Database Exception: ". $e->getMessage(), 0, $e);
        }
    }
    
    /**
     * findbyDescription method finds for user with entered description
     * @param Job $job
     * @throws DatabaseException
     * @return array
     */
    function findByDescription(Job $job){
        Log::info("Entering SecurityDAO::findByDescription()");
        
        try{
            $description = $job->getDescription();
            $statement = $this->connection->prepare("SELECT ID, JOB_TITLE, CATEGORY, DESCRIPTION, REQUIREMENTS, COMPANY, LOCATION, SALARY FROM JOB WHERE DESCRIPTION LIKE CONCAT('%', :description, '%') ");
            
            // if the statement goes wrong return error message
            if(!$statement){
                echo "Something wrong in the binding process.sql error?";
                exit;
            }
            
            //bindParam lastname and executes statement
            $statement->bindParam(':description', $description);
            $statement->execute();
            
            //if statement executes successfully
            if($statement->rowCount() > 0){
                Log::info("Exit SecurityDAO.findByDescription() ");
                
                //fetching jobs from database
                $jobs = $statement->fetchAll();
                
                //return jobs object
                return $jobs;
            }
            
        }catch(PDOException $e)
        {
            // catch exception and throw DatabaseException
            Log::error("Exception: ", array("message " => $e->getMessage()));
            throw new DatabaseException("Database Exception: ". $e->getMessage(), 0, $e);
        }
    } 
    
    /**
     * findBySkills method finds for job with matched skills
     * @param Job $job
     * @throws DatabaseException
     * @return array
     */
    function findBySkills($skills){
        Log::info("Entering SecurityDAO::findBySkills()");
        
        try{
       //select jobs with education that matches description or requirements in database
            $statement = $this->connection->prepare("SELECT ID, JOB_TITLE, CATEGORY, DESCRIPTION, REQUIREMENTS, COMPANY, LOCATION, SALARY FROM JOB WHERE REQUIREMENTS LIKE CONCAT('%', :skills, '%') OR DESCRIPTION LIKE CONCAT('%', :skills, '%')");
            
            // if the statement goes wrong return error message
            if(!$statement){
                echo "Something wrong in the binding process.sql error?";
                exit;
            }
            
            //bindParam lastname and executes statement
            $statement->bindParam(':skills', $skills);
            $statement->execute();
            
            //if statement executes successfully
            if($statement->rowCount() > 0){
                Log::info("Exit SecurityDAO.findBySkills() ");
                
                // fetch all result found
                $jobs = $statement->fetchAll();
                
                //return jobs object
                return $jobs;
            }
            
        }catch(PDOException $e)
        {
            // catch exception and throw DatabaseException
            Log::error("Exception: ", array("message " => $e->getMessage()));
            throw new DatabaseException("Database Exception: ". $e->getMessage(), 0, $e);
        }
    }
    
    /**
     * findByEducation method finds for job with matched skills
     * @param Job $job
     * @throws DatabaseException
     * @return array
     */
    function findByEducation($education){
        Log::info("Entering SecurityDAO::findByEducation()");
        
        try{
       //select jobs with education that matches description, requirements or category in database
            $statement = $this->connection->prepare("SELECT ID, JOB_TITLE, CATEGORY, DESCRIPTION, REQUIREMENTS, COMPANY, LOCATION, SALARY FROM JOB WHERE REQUIREMENTS LIKE CONCAT('%', :education, '%') OR DESCRIPTION LIKE CONCAT('%', :education, '%') OR CATEGORY LIKE CONCAT('%', :education, '%')");
            
            // if the statement goes wrong return error message
            if(!$statement){
                echo "Something wrong in the binding process.sql error?";
                exit;
            }
            
            //bindParam lastname and executes statement
            $statement->bindParam(':education', $education);
            $statement->execute();
            
            //if statement executes successfully
            if($statement->rowCount() > 0){
                Log::info("Exit SecurityDAO.findByEducation() ");
                
                // fetch all result found
                $jobs = $statement->fetchAll();
                
                //return jobs object
                return $jobs;
            }
            
        }catch(PDOException $e)
        {
            // catch exception and throw DatabaseException
            Log::error("Exception: ", array("message " => $e->getMessage()));
            throw new DatabaseException("Database Exception: ". $e->getMessage(), 0, $e);
        }
    }
    
    
    /**
     * findByEducation method finds for job with matched skills
     * @param Job $job
     * @throws DatabaseException
     * @return array
     */
    function findByJobHistory($jobhistory){
        Log::info("Entering SecurityDAO::findByJobHistory()");
        
        try{
            // Select job infomation from job database table that matches job_title
            $statement = $this->connection->prepare("SELECT ID, JOB_TITLE, CATEGORY, DESCRIPTION, REQUIREMENTS, COMPANY, LOCATION, SALARY FROM JOB WHERE JOB_TITLE LIKE CONCAT('%', :jobhistory, '%') ");
            
            // if the statement goes wrong return error message
            if(!$statement){
                echo "Something wrong in the binding process.sql error?";
                exit;
            }
            
            //bindParam lastname and executes statement
            $statement->bindParam(':jobhistory', $jobhistory);
            $statement->execute();
            
            //if statement executes successfully
            if($statement->rowCount() > 0){
                Log::info("Exit SecurityDAO.findByJobHistory() ");
                
                // fetch all result found
                $jobs = $statement->fetchAll();
                
                //return jobs object
                return $jobs;
            }
            
        }catch(PDOException $e)
        {
            // catch exception and throw DatabaseException
            Log::error("Exception: ", array("message " => $e->getMessage()));
            throw new DatabaseException("Database Exception: ". $e->getMessage(), 0, $e);
        }
    }
}

