<?php
/* CLC Project version 3.0
 * UserDataService version 3.0
 * Adam Bender and Jim Nguyen
 * February 19th, 2020
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
    
    
    public function __construct($connection){
        $this->connection = $connection;
    }
    
    //createJob method connects to database and add new job information into SQL statement
    function createJob(Job $job){
        Log::info("Entering JobDataService::createJob()");
        try{
            // Insert job information into Job table
            $statement = $this->connection->prepare("INSERT INTO JOB (JOB_TITLE, CATEGORY, DESCRIPTION, REQUIREMENTS, COMPANY, LOCATION, SALARY) VALUES ( :jobtitle, :category, :description, :requirements, :company, :location, :salary)");
            
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
    
    //deleteJob method connects database and delete job using MySQL statement
    function deleteJob(Job $job){
        Log::info("Entering JobDataService::deleteJob()");
        try{
            $statement = $this->connection->prepare("DELETE FROM JOB WHERE ID = :id");
            
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
    
    // updateJob method render data and update user information in database
    function updateJob(Job $job)
    {
        Log::info("Entering SecurityDAO::updateJob()");
        
        try{
            //update user information in database
            $statement = $this->connection->prepare("UPDATE JOB SET ID = :id, JOB_TITLE = :jobtitle, CATEGORY = :category, DESCRIPTION = :description, REQUIREMENTS = :requirements, COMPANY = :company, LOCATION = :location, SALARY = :salary WHERE ID = :id");
            
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
    
    // findAllJob method returns all users exist in database
    function findAllJobs(){
        Log::info("Entering SecurityDAO::findAllJob()");
        
        try{
            // Select all user in database
            $statement = $this->connection->prepare("SELECT * FROM JOB");
            
            if(!$statement){
                echo "Something wrong in the binding process.sql error?";
                exit;
            }
            
            //execute statement
            $statement->execute();
            
            //if statement execute successfully return $users
            if($statement->rowCount() > 0){
                
                Log::info("Exit SecurityDAO.findAllJob with true");
                $jobs = $statement->fetchAll();
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
    
    // findById method find user with matched id in database
    function findById($id){
        Log::info("Entering SecurityDAO::findById()");
        
        try{
            
            $statement = $this->connection->prepare("SELECT ID, JOB_TITLE, CATEGORY, DESCRIPTION, REQUIREMENTS, COMPANY, LOCATION, SALARY FROM JOB WHERE ID = :id ");
            
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
                
                return $result;
            }
            
        }catch(PDOException $e)
        {
            // catch exception and throw DatabaseException
            Log::error("Exception: ", array("message " => $e->getMessage()));
            throw new DatabaseException("Database Exception: ". $e->getMessage(), 0, $e);
        }
    }
    
    // findbyTitle method finds for user with entered title
    function findByTitle(Job $job){
        Log::info("Entering SecurityDAO::findByTitle()");
        
        try{
            $jobtitle = $job->getJobtitle();
            $statement = $this->connection->prepare("SELECT ID, JOB_TITLE, CATEGORY, DESCRIPTION, REQUIREMENTS, COMPANY, LOCATION, SALARY FROM USER WHERE JOB_TITLE LIKE CONCAT('%', :jobtitle, '%') ");
            
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
                $users = $statement->fetchAll();
                return $users;
            }
            
        }catch(PDOException $e)
        {
            // catch exception and throw DatabaseException
            Log::error("Exception: ", array("message " => $e->getMessage()));
            throw new DatabaseException("Database Exception: ". $e->getMessage(), 0, $e);
        }
    }  
    
    // findByLocation method finds for user with entered location
    function findByLocation(Job $job){
        Log::info("Entering SecurityDAO::findByLocation()");
        
        try{
            $location = $job->getLocation();
            $statement = $this->connection->prepare("SELECT ID, JOB_TITLE, CATEGORY, DESCRIPTION, REQUIREMENTS, COMPANY, LOCATION, SALARY FROM USER WHERE JOB_TITLE LIKE CONCAT('%', :location, '%') ");
            
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
                return $jobs;
            }
            
        }catch(PDOException $e)
        {
            // catch exception and throw DatabaseException
            Log::error("Exception: ", array("message " => $e->getMessage()));
            throw new DatabaseException("Database Exception: ". $e->getMessage(), 0, $e);
        }
    }
    
    // findbyCategory method finds for user with entered title
    function findByCategory(Job $job){
        Log::info("Entering SecurityDAO::findByCategory()");
        
        try{
            $category = $job->getJobtitle();
            $statement = $this->connection->prepare("SELECT ID, JOB_TITLE, CATEGORY, DESCRIPTION, REQUIREMENTS, COMPANY, LOCATION, SALARY FROM USER WHERE JOB_TITLE LIKE CONCAT('%', :category, '%') ");
            
            if(!$statement){
                echo "Something wrong in the binding process.sql error?";
                exit;
            }
            
            //bindParam lastname and executes statement
            $statement->bindParam(':category', $category);
            $statement->execute();
            
            //if statement executes successfully
            if($statement->rowCount() > 0){
                Log::info("Exit SecurityDAO.findByCategory() ");
                
                //fetching users from database
                $jobs = $statement->fetchAll();
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

