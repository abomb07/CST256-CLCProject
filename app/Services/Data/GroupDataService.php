<?php
/* CLC Project version 6.0
 * UserDataService version 6.0
 * Adam Bender and Jim Nguyen
 * April 5, 2020
 * GroupDataService handle methods through MySQL Statement
 */
namespace App\Services\Data;

use App\Model\Group;

use PDO;
use PDOException;
use Illuminate\Support\Facades\Log;
use App\Services\Utility\DatabaseException;

class GroupDataService
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
     * createGroup method connects to database and add new group information into SQL statement
     * @param Group $group
     * @throws DatabaseException
     * @return boolean
     */
    function createGroup(Group $group){
        Log::info("Entering JobHistoryDataService::createGroup()");
        try{
            // Insert group information into Group table
            $statement = $this->connection->prepare("INSERT INTO AFFINITY_GROUP (NAME, DESCRIPTION, OWNER_ID) VALUES (:name, :description, :owner_id)");
            
            if(!$statement){
                echo "Something wrong in the binding process.sql error?";
                exit;
            }
            
            $name = $group->getName();
            $description = $group->getDescription();
            $owner_id = $group->getOwner_id();
            
            $statement->bindParam(':name', $name, PDO::PARAM_STR);
            $statement->bindParam(':description', $description, PDO::PARAM_STR);
            $statement->bindParam(':owner_id', $owner_id, PDO::PARAM_STR);
            
      
            $statement->execute();
            
            // if statement succeses return true, else return false
            if($statement->rowCount() > 0){
                
                Log::info("Exit GroupDataService.createGroup with true");
                return true;
                
            }else{
                Log::info("Exit GroupDataService.createGroup with false");
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
     * findAllGroups method finds all groups in database
     * @throws DatabaseException
     * @return array
     */
    function findAllGroups(){
        Log::info("Entering GroupDataService::findAllGroups()");
        
        try{
            
            $statement = $this->connection->prepare("SELECT * FROM AFFINITY_GROUP");
            
            if(!$statement){
                echo "Something wrong in the binding process.sql error?";
                exit;
            }
           
            $statement->execute();
            
            if($statement->rowCount() > 0){
                Log::info("Exit GroupDataService.findAllGroups");
                
                //fetches user from database and returns $user
                $result = $statement->fetchAll();
                
                return $result;
            }
            else
            {
                return array();
            }
            
        }catch(PDOException $e)
        {
            // catch exception and throw DatabaseException
            Log::error("Exception: ", array("message " => $e->getMessage()));
            throw new DatabaseException("Database Exception: ". $e->getMessage(), 0, $e);
        }
    }
    
    /**
     * deleteGroup method connects database and delete group using MySQL statement
     * @param Group $group
     * @throws DatabaseException
     * @return boolean
     */
    function deleteGroup(Group $group){
        Log::info("Entering GroupDataService::deleteGroup()");
        try{
            $statement = $this->connection->prepare("DELETE FROM AFFINITY_GROUP WHERE ID = :id");
            
            if(!$statement){
                echo "Something wrong in the binding process.sql error?";
                exit;
            }
            
            $id = $group->getId();
            $statement->bindParam(':id',  $id, PDO::PARAM_INT);
            $statement->execute();
            
            if($statement->rowCount() > 0){
                
                Log::info("Exit GroupDataService.deleteGroup with true");
                return true;
                
            }else{
                Log::info("Exit GroupDataService.deleteGroup with false");
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
     * updateGroup method render data and update group information in database
     * @param Group $group
     * @throws DatabaseException
     * @return boolean
     */
    function updateGroup(Group $group)
    {
        Log::info("Entering GroupDataService::updateGroup()");
        
        try{
            //update user information in database
            $statement = $this->connection->prepare("UPDATE AFFINITY_GROUP SET ID = :id, NAME = :name, DESCRIPTION = :description, OWNER_ID = :owner_id WHERE ID = :id");
            
            if(!$statement){
                echo "Something wrong in the binding process.sql error?";
                exit;
            }
            
            $id = $group->getId();
            $name = $group->getName();
            $description = $group->getDescription();
            $owner_id = $group->getOwner_id();
            
            $statement->bindParam(':id', $id, PDO::PARAM_STR);
            $statement->bindParam(':name', $name, PDO::PARAM_STR);
            $statement->bindParam(':description', $description, PDO::PARAM_STR);
            $statement->bindParam(':owner_id', $owner_id, PDO::PARAM_STR);
            $statement->execute();
            
            //if statement executes successfully returns true, else returns false
            if($statement->rowCount() > 0){
                Log::info("Exit GroupDataService.updateGroup with true");
                return true;
                
            }else{
                Log::info("Exit GroupDataService.updateGroup with false");
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
     * findByOwnerId method find groups with matched owner id in database
     * @param $owner_id
     * @throws DatabaseException
     * @return array
     */
    function findByOwnerId($owner_id){
        Log::info("Entering GroupDataService::findByOwnerId()");
        
        try{
            
            $statement = $this->connection->prepare("SELECT ID, NAME, DESCRIPTION, OWNER_ID FROM AFFINITY_GROUP WHERE OWNER_ID = :owner_id ");
            
            if(!$statement){
                echo "Something wrong in the binding process.sql error?";
                exit;
            }
            //bindParam $id
            $statement->bindParam(':owner_id', $owner_id);
            $statement->execute();
            
            if($statement->rowCount() > 0){
                Log::info("Exit GroupDataService.findByOwnerId");
                
                //fetches group from database and returns $user
                
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
     * findById method find group with matched id in database
     * @param $id
     * @throws DatabaseException
     * @return \App\Model\Group
     */
    function findById($id){
        Log::info("Entering GroupDataService::findById()");
        
        try{
            
            $statement = $this->connection->prepare("SELECT ID, NAME, DESCRIPTION, OWNER_ID FROM AFFINITY_GROUP WHERE ID = :id ");
            
            if(!$statement){
                echo "Something wrong in the binding process.sql error?";
                exit;
            }
            //bindParam $id
            $statement->bindParam(':id', $id);
            $statement->execute();
            
            if($statement->rowCount() == 1){
                Log::info("Exit GroupDataService.findById");
                
                //fetches user from database and returns $user
                $row = $statement->fetch(PDO::FETCH_ASSOC);
                $result = new Group($row['ID'], $row['NAME'], $row['DESCRIPTION'], $row['OWNER_ID']);
                
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
     * findByGroupName method find group with matched name in database
     * @param $name
     * @throws DatabaseException
     * @return \App\Model\Group
     */
    function findByGroupName($name)
    {
        Log::info("Entering GroupDataService::findByGroupName()");
        
        try{
            $statement = $this->connection->prepare("SELECT ID, NAME, DESCRIPTION, OWNER_ID FROM AFFINITY_GROUP WHERE NAME = :name ");
            
            if(!$statement){
                echo "Something wrong in the binding process.sql error?";
                exit;
            }
            //bindParam $id
            $statement->bindParam(':name', $name);
            $statement->execute();
            
            if($statement->rowCount() == 1){
                Log::info("Exit GroupDataService.findByGroupName");
                
                //fetches group from database and returns $result
                $row = $statement->fetch(PDO::FETCH_ASSOC);
                $result = new Group($row['ID'], $row['NAME'], $row['DESCRIPTION'], $row['OWNER_ID']);
                
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

