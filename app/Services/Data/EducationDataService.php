<?php
/* CLC Project version 5.0
 * EducationDataService version 5.0
 * Adam Bender and Jim Nguyen
 * March 15, 2020
 * EducationDataService handle methods through MySQL Statement
 */
namespace App\Services\Data;

use Illuminate\Support\Facades\Log;
use PDO;
use PDOException;
use App\Services\Utility\DatabaseException;
use App\Model\Education;

class EducationDataService
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
     * createEducation function connect database and add new education using MySQL statement
     * @param Education $education
     * @throws DatabaseException
     * @return boolean
     */
    function createEducation(Education $education)
    {
        Log::info("Entering EducationDataService::createEducation()");
        try{
            /* Insert user information to User
             * STATUS is set to be active when registered
             */
            $statement = $this->connection->prepare("INSERT INTO EDUCATION ( SCHOOL, DEGREE, FIELD, GRADUATION_YEAR, USER_ID) VALUES (:school, :degree, :field, :graduationyear, :user_id)");
            
            if(!$statement){
                echo "Something wrong in the binding process.sql error?";
                exit;
            }
            
            $school = $education->getSchool();
            $degree = $education->getDegree();
            $field = $education->getField();
            $graduationyear = $education->getGraduationyear();
            $user_id = $education->getUser_id();
            
            //bindParam properties
            $statement->bindParam(':school', $school);
            $statement->bindParam(':degree', $degree);
            $statement->bindParam(':field', $field);
            $statement->bindParam(':graduationyear', $graduationyear);
            $statement->bindParam(':user_id', $user_id);
            $statement->execute();
            
            // if statement succeses return true, else return false
            if($statement->rowCount() > 0){
                
                Log::info("Exit EducationDataService.createEducation with true");
                return true;
                
            }else{
                Log::info("Exit EducationDataService.createEducation with false");
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
     * findById method find education with matched id in database
     * @param $id
     * @throws DatabaseException
     * @return \App\Model\Education
     */
    function findById($id){
        Log::info("Entering EducationDataService::findById()");
        
        try{
            
            $statement = $this->connection->prepare("SELECT ID, SCHOOL, DEGREE, FIELD, GRADUATION_YEAR, USER_ID FROM EDUCATION WHERE ID = :id ");
            
            if(!$statement){
                echo "Something wrong in the binding process.sql error?";
                exit;
            }
            //bindParam $id
            $statement->bindParam(':id', $id);
            $statement->execute();
            
            if($statement->rowCount() == 1){
                Log::info("Exit SkillDataService.findById");
                
                //fetches education from database and returns $education
                $row = $statement->fetch(PDO::FETCH_ASSOC);
                $result = new Education($row['ID'],$row['SCHOOL'],$row['DEGREE'], $row['FIELD'], $row['GRADUATION_YEAR'], $row['USER_ID']);
                
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
     * findByUserId method find education with matched id in database
     * @param $user_id
     * @throws DatabaseException
     * @return array
     */
    function findByUserId($user_id){
        Log::info("Entering EducationDataService::findByUserId()");
        
        try{
 
            $statement = $this->connection->prepare("SELECT ID, SCHOOL, DEGREE, FIELD, GRADUATION_YEAR FROM EDUCATION WHERE USER_ID = :user_id ");
            
            if(!$statement){
                echo "Something wrong in the binding process.sql error?";
                exit;
            }
            //bindParam $user_id
            $statement->bindParam(':user_id', $user_id);
            $statement->execute();
            
            if($statement->rowCount() > 0 ){
                Log::info("Exit SkillDataService.findByUserId");
                
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
     * updateEducation method render data and update education information in database
     * @param Education $education
     * @throws DatabaseException
     * @return boolean
     */
    function updateEducation(Education $education)
    {
        Log::info("Entering EducationDataService::updateEducation()");
        
        try{
            $id = $education->getId();
            $school = $education->getSchool();
            $degree = $education->getDegree();
            $field = $education->getField();
            $graduationyear = $education->getGraduationyear();
            
            //update user information in database
            $statement = $this->connection->prepare("UPDATE EDUCATION SET SCHOOL = :school, DEGREE = :degree, FIELD = :field, GRADUATION_YEAR = :graduationyear WHERE ID = :id");
            
            if(!$statement){
                echo "Something wrong in the binding process.sql error?";
                exit;
            }
            //bindParam properties
            $statement->bindParam(':id', $id);
            $statement->bindParam(':school', $school);
            $statement->bindParam(':degree', $degree);
            $statement->bindParam(':field', $field);
            $statement->bindParam(':graduationyear', $graduationyear);
            
            $statement->execute();
            
            //if statement executes successfully returns true, else returns false
            if($statement->rowCount() > 0){
                Log::info("Exit EducationDataService.updateEducation() with true");
                return true;
                
            }else{
                Log::info("Exit EducationDataService.updateEducation() with false");
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
     * deleteEducation function connect database and delete education using MySQL statement
     * @param Education $education
     * @throws DatabaseException
     * @return boolean
     */
    function deleteEducation(Education $education)
    {
        Log::info("Entering EducationDataService::deleteEducation()");
        try{
            // delete education in database with matched id
            $statement = $this->connection->prepare("DELETE FROM EDUCATION WHERE ID = :id");
            
            if(!$statement){
                echo "Something wrong in the binding process.sql error?";
                exit;
            }
            
            $id = $education->getId();
            
            /* Execute prepared statement with question mark placedholder
             * code retrieved from php.net PDO Documentation
             * URL: https://www.php.net/manual/en/pdostatement.bindparam.php
             */
            //execute statement
            $statement->bindParam(':id',  $id, PDO::PARAM_INT) ;
            $statement->execute();
            
            //if statement executes successfully returns true, else returns false
            if($statement->rowCount() > 0){
                
                Log::info("Exit EducationDataService.deleteEducation() with true");
                return true;
                
            }else{
                Log::info("Exit EducationDataService.deleteEducation() with false");
                return false;
            }
        }catch(PDOException $e)
        {
            // catch exception and throw DatabaseException
            Log::error("Exception: ", array("message " => $e->getMessage()));
            throw new DatabaseException("Database Exception: ". $e->getMessage(), 0, $e);
        }
    }
}

