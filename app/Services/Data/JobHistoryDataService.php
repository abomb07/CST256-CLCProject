<?php
/* CLC Project version 4.0
 * JobHistoryDataService version 4.0
 * Adam Bender and Jim Nguyen
 * March 8, 2020
 * JobHistoryDataService handle methods through MySQL Statement
 */
namespace App\Services\Data;

use PDO;
use PDOException;
use Illuminate\Support\Facades\Log;
use App\Services\Utility\DatabaseException;

use App\Model\JobHistory;

class JobHistoryDataService
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
     * createJobHistory method connects to database and add new job history information into SQL statement
     * @param JobHistory $jobhistory
     * @throws DatabaseException
     * @return boolean
     */
    function createJobHistory(JobHistory $jobhistory){
        Log::info("Entering JobHistoryDataService::createJobHistory()");
        try{
            // Insert job information into Job table
            $statement = $this->connection->prepare("INSERT INTO JOB_HISTORY (TITLE, COMPANY, START_DATE, END_DATE, USER_ID) VALUES ( :title, :company, :startdate, :enddate, :user_id)");
            
            if(!$statement){
                echo "Something wrong in the binding process.sql error?";
                exit;
            }
            
            $title = $jobhistory->getTitle();
            $company = $jobhistory->getCompany();
            $startdate = $jobhistory->getStartdate();
            $enddate = $jobhistory->getEnddate();
            $user_id = $jobhistory->getUser_id();
            
            $statement->bindParam(':title', $title, PDO::PARAM_STR);
            $statement->bindParam(':company', $company, PDO::PARAM_STR);
            $statement->bindParam(':startdate', $startdate, PDO::PARAM_STR);
            $statement->bindParam(':enddate', $enddate, PDO::PARAM_STR);
            $statement->bindParam(':user_id',  $user_id, PDO::PARAM_STR);
      
            $statement->execute();
            
            // if statement succeses return true, else return false
            if($statement->rowCount() > 0){
                
                Log::info("Exit JobHistoryDataService.createJobHistory with true");
                return true;
                
            }else{
                Log::info("Exit JobHistoryDataService.createJobHistory with false");
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
     * deleteJobHistory method connects database and delete job history using MySQL statement
     * @param JobHistory $jobhistory
     * @throws DatabaseException
     * @return boolean
     */
    function deleteJobHistory(JobHistory $jobhistory){
        Log::info("Entering JobHistoryDataService::deleteJob()");
        try{
            $statement = $this->connection->prepare("DELETE FROM JOB_HISTORY WHERE ID = :id");
            
            if(!$statement){
                echo "Something wrong in the binding process.sql error?";
                exit;
            }
            
            $id = $jobhistory->getId();
            $statement->bindParam(':id',  $id, PDO::PARAM_INT);
            $statement->execute();
            
            if($statement->rowCount() > 0){
                
                Log::info("Exit JobHistoryDataService.deleteJobHistory with true");
                return true;
                
            }else{
                Log::info("Exit JobHistoryDataService.deleteJobHistory with false");
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
     * updateJobHistory method render data and update job history information in database
     * @param JobHistory $jobhistory
     * @throws DatabaseException
     * @return boolean
     */
    function updateJobHistory(JobHistory $jobhistory)
    {
        Log::info("Entering JobHistoryDataService::updateJobHistory()");
        
        try{
            //update user information in database
            $statement = $this->connection->prepare("UPDATE JOB_HISTORY SET TITLE = :title, COMPANY = :company, START_DATE = :startdate, END_DATE = :enddate, USER_ID = :user_id WHERE ID = :id");
            
            if(!$statement){
                echo "Something wrong in the binding process.sql error?";
                exit;
            }
            
            $id = $jobhistory->getId();
            $title = $jobhistory->getTitle();
            $company = $jobhistory->getCompany();
            $startdate = $jobhistory->getStartdate();
            $enddate = $jobhistory->getEnddate();
            $user_id = $jobhistory->getUser_id();
            
            $statement->bindParam(':id', $id, PDO::PARAM_STR);
            $statement->bindParam(':title', $title, PDO::PARAM_STR);
            $statement->bindParam(':company', $company, PDO::PARAM_STR);
            $statement->bindParam(':startdate', $startdate, PDO::PARAM_STR);
            $statement->bindParam(':enddate', $enddate, PDO::PARAM_STR);
            $statement->bindParam(':user_id',  $user_id, PDO::PARAM_STR);
            $statement->execute();
            
            //if statement executes successfully returns true, else returns false
            if($statement->rowCount() > 0){
                Log::info("Exit JobDataService.updateJobHistory with true");
                return true;
                
            }else{
                Log::info("Exit JobDataService.updateJobHistory with false");
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
     * findByUserId method find job history with matched user id in database
     * @param $user_id
     * @throws DatabaseException
     * @return array
     */
    function findByUserId($user_id){
        Log::info("Entering JobHistoryDataService::findByUserId()");
        
        try{
            
            $statement = $this->connection->prepare("SELECT ID, TITLE, COMPANY, START_DATE, END_DATE , USER_ID FROM JOB_HISTORY WHERE USER_ID = :user_id ");
            
            if(!$statement){
                echo "Something wrong in the binding process.sql error?";
                exit;
            }
            //bindParam $id
            $statement->bindParam(':user_id', $user_id);
            $statement->execute();
            
            if($statement->rowCount() > 0){
                Log::info("Exit SecurityDAO.findByUserId");
                
                //fetches user from database and returns $user
                
                $result = $statement->fetchAll();
                
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
     * findById method find job history with matched id in database
     * @param $id
     * @throws DatabaseException
     * @return \App\Model\JobHistory
     */
    function findById($id){
        Log::info("Entering JobHistoryDataService::findById()");
        
        try{
            
            $statement = $this->connection->prepare("SELECT ID, TITLE, COMPANY, START_DATE, END_DATE, USER_ID FROM JOB_HISTORY WHERE ID = :id ");
            
            
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
                $result = new JobHistory($row['ID'], $row['TITLE'], $row['COMPANY'], $row['START_DATE'], $row['END_DATE'], $row['USER_ID']);
                
                return $result;
            }
            
        }catch(PDOException $e)
        {
            // catch exception and throw DatabaseException
            Log::error("Exception: ", array("message " => $e->getMessage()));
            throw new DatabaseException("Database Exception: ". $e->getMessage(), 0, $e);
        }
    }    
}
