<?php
/* CLC Project version 7.0
 * SkillDataService version 7.0
 * Adam Bender and Jim Nguyen
 * April 17, 2020
 * SkillDataService handle methods through MySQL Statement
 */
namespace App\Services\Data;

use App\Model\Skill;
use Illuminate\Support\Facades\Log;
use PDO;
use PDOException;
use App\Services\Utility\DatabaseException;

class SkillDataService
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
     * createSkill function connect database and add new skill using MySQL statement
     * @param Skill $skill
     * @throws DatabaseException
     * @return boolean
     */
    function createSkill(Skill $skill)
    {
        Log::info("Entering SkillDataService::createSkill()");
        try{
            /* Insert user information to User
             * STATUS is set to be active when registered
             */
            $statement = $this->connection->prepare("INSERT INTO SKILL ( SKILL, USER_ID) VALUES (:skills, :user_id)");
            
            if(!$statement){
                echo "Something wrong in the binding process.sql error?";
                exit;
            }
            
            $user_id= $skill->getUser_id();
            $skills = $skill->getSkill();
            
            //bindParam properties
            $statement->bindParam(':skills', $skills);
            $statement->bindParam(':user_id', $user_id);
            $statement->execute();
            
            // if statement succeses return true, else return false
            if($statement->rowCount() > 0){
                
                Log::info("Exit SkillDataService.createSkill with true");
                return true;
                
            }else{
                Log::info("Exit SkillDataService.createSkill with false");
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
     * findByUserId method find skill with matched user id in database
     * @param $user_id
     * @throws DatabaseException
     * @return array
     */
    function findByUserId($user_id){
        Log::info("Entering SkillDataService::findByUserId()");
        
        try{
            // Select skill with matched user id
            $statement = $this->connection->prepare("SELECT ID, SKILL FROM SKILL WHERE USER_ID = :user_id ");
            
            if(!$statement){
                echo "Something wrong in the binding process.sql error?";
                exit;
            }
            //bindParam $id
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
     * findById method find skill with matched id in database
     * @param $id
     * @throws DatabaseException
     * @return \App\Model\Skill
     */
    function findById($id){
        Log::info("Entering SkillDataService::findById()");
        
        try{
            
            // Select skill with matched id
            $statement = $this->connection->prepare("SELECT ID, SKILL, USER_ID FROM SKILL WHERE ID = :id ");
            
            if(!$statement){
                echo "Something wrong in the binding process.sql error?";
                exit;
            }
            //bindParam $id
            $statement->bindParam(':id', $id);
            $statement->execute();
            
            // if finds result fetch skill information and returns result
            if($statement->rowCount() == 1){
                Log::info("Exit SkillDataService.findById");
                
                //fetches user from database and returns $user
                $row = $statement->fetch(PDO::FETCH_ASSOC);
                $result = new Skill($row['ID'], $row['SKILL'], $row['USER_ID']);
                
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
     * updateSkill method render data and update skill information in database
     * @param Skill $skill
     * @throws DatabaseException
     * @return boolean
     */
    function updateSkill(Skill $skill)
    {
        Log::info("Entering SkillDataService::updateSkill()");
        
        try{
            $id = $skill->getId();
            $skill = $skill->getSkill();
            //update user information in database with matched id
            $statement = $this->connection->prepare("UPDATE SKILL SET SKILL = :skill WHERE ID = :id");
            
            if(!$statement){
                echo "Something wrong in the binding process.sql error?";
                exit;
            }
            //bindParam $id
            $statement->bindParam(':id', $id);
            $statement->bindParam(':skill', $skill);
            $statement->execute();
            
            //if statement executes successfully returns true, else returns false
            if($statement->rowCount() > 0){
                Log::info("Exit SkillDataService.updateSkill() with true");
                return true;
                
            }else{
                Log::info("Exit SkillDataService.updateSkill() with false");
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
     * deleteSkill function connect database and delete skill using MySQL statement
     * @param Skill $skill
     * @throws DatabaseException
     * @return boolean
     */
    function deleteSkill(Skill $skill)
    {
        Log::info("Entering SkillDataService::deleteSkill()");
        try{
            // delete user in database with mtach id
            $statement = $this->connection->prepare("DELETE FROM SKILL WHERE ID = :id");
            
            if(!$statement){
                echo "Something wrong in the binding process.sql error?";
                exit;
            }
            
            $id = $skill->getId();
            
            /* Execute prepared statement with question mark placedholder
             * code retrieved from php.net PDO Documentation
             * URL: https://www.php.net/manual/en/pdostatement.bindparam.php
             */
            //execute statement
            $statement->bindParam(':id',  $id, PDO::PARAM_INT) ;
            $statement->execute();
            
            //if statement executes successfully returns true, else returns false
            if($statement->rowCount() > 0){
                
                Log::info("Exit SkillDataService.deleteSkill() with true");
                return true;
                
            }else{
                Log::info("Exit SkillDataService.deleteSkill() with false");
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
     * deleteSkillByUserID function connect database and deleteSkillByUserID using MySQL statement
     * @param $user_id
     * @throws DatabaseException
     * @return boolean
     */
    function deleteSkillByUserID($user_id)
    {
        Log::info("Entering SkillDataService::deleteSkillByUserID()");
        try{
            // delete user in database with mtach id
            $statement = $this->connection->prepare("DELETE FROM SKILL WHERE USER_ID = :user_id");
            
            if(!$statement){
                echo "Something wrong in the binding process.sql error?";
                exit;
            }
            
            
            
            //bindParam properties
            
            $statement->bindParam(':user_id',  $user_id, PDO::PARAM_INT) ;
            //execute statement
            $statement->execute();
            
            //if statement executes successfully returns true, else returns false
            if($statement->rowCount() > 0){
                
                Log::info("Exit SkillDataService.deleteSkillByUserID() with true");
                return true;
                
            }else{
                Log::info("Exit SkillDataService.deleteSkillByUserID() with false");
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

