<?php
/* CLC Project version 7.0
 * MemberDataService version 7.0
 * Adam Bender and Jim Nguyen
 * April 17, 2020
 * MemberDataService handle methods through MySQL Statement
 */
namespace App\Services\Data;

use App\Model\Member;
use Illuminate\Support\Facades\Log;
use PDO;
use PDOException;
use App\Services\Utility\DatabaseException;
use App\Model\Group;
use App\Model\User;

class MemberDataService
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
     * createMember method connects to database and add new member information into SQL statement
     * @param Member $member
     * @throws DatabaseException
     * @return boolean
     */
    function createMember(Member $member){
        Log::info("Entering MemberDataService::createMember()");
        try{
            // Insert group information into Group table
            $statement = $this->connection->prepare("INSERT INTO MEMBER (AFFINITY_GROUP_ID, USER_ID) VALUES (:group_id, :user_id)");
            
            if(!$statement){
                echo "Something wrong in the binding process.sql error?";
                exit;
            }
            
            $group_id = $member->getGroup_id();
            $user_id = $member->getUser_id();
            
            //bindParam properties
            $statement->bindParam(':group_id', $group_id, PDO::PARAM_STR);
            $statement->bindParam(':user_id', $user_id, PDO::PARAM_STR);           
            
            // execute statement
            $statement->execute();
            
            // if statement succeses return true, else return false
            if($statement->rowCount() > 0){
                
                Log::info("Exit MemberDataService.createMember() with true");
                return true;
                
            }else{
                Log::info("Exit MemberDataService.createMember() with false");
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
     * deleteMember method connects database and delete member using MySQL statement
     * @param Member $member
     * @throws DatabaseException
     * @return boolean
     */
    function deleteMember(Member $member){
        Log::info("Entering MemberDataService::deleteMember()");
        try{
            // Delete member with user_id and group_id
            $statement = $this->connection->prepare("DELETE FROM MEMBER WHERE USER_ID = :user_id AND AFFINITY_GROUP_ID = :group_id");
            
            if(!$statement){
                echo "Something wrong in the binding process.sql error?";
                exit;
            }
            
            $user_id = $member->getUser_id();
            $group_id = $member->getGroup_id();
            
            //bindParam properties
            $statement->bindParam(':user_id',  $user_id, PDO::PARAM_INT);
            $statement->bindParam(':group_id',  $group_id, PDO::PARAM_INT);
            
            //execute statement 
            $statement->execute();
            
            //if statement execute successfully, return true, else return false
            if($statement->rowCount() > 0){
                
                Log::info("Exit MemberDataService.deleteMember() with true");
                return true;
                
            }else{
                Log::info("Exit MemberDataService.deleteMember() with false");
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
     * deleteByGroupId method delete member with matched id in database
     * @param $group_id
     * @throws DatabaseException
     * @return boolean
     */
    function deleteByGroupId($group_id){
        Log::info("Entering MemberDataService::deleteByGroupId()");
        
        try{
            // delete member with match group_id
            $statement = $this->connection->prepare("DELETE FROM MEMBER WHERE AFFINITY_GROUP_ID = :group_id ");
            
            if(!$statement){
                echo "Something wrong in the binding process.sql error?";
                exit;
            }
            //bindParam $id
            $statement->bindParam(':group_id', $group_id);
            $statement->execute();
            
            //if statement execute successfully, return true, else return false
            if($statement->rowCount() > 0){
                
                Log::info("Exit MemberDataService.deleteByGroupId() with true");
                return true;
            }else{
                Log::info("Exit MemberDataService.deleteByGroupId() with false");
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
     * deleteByUserId method delete member with matched id in database
     * @param $group_id
     * @throws DatabaseException
     * @return boolean
     */
    function deleteByUserId($user_id){
        Log::info("Entering MemberDataService::deleteByUserId()");
        
        try{
            // Delete member with user id
            $statement = $this->connection->prepare("DELETE FROM MEMBER WHERE USER_ID = :user_id ");
            
            if(!$statement){
                echo "Something wrong in the binding process.sql error?";
                exit;
            }
            //bindParam $id
            $statement->bindParam(':user_id', $user_id);
            $statement->execute();
            
            //if statement execute successfully, return true, else return false
            if($statement->rowCount() > 0){
                
                Log::info("Exit MemberDataService.deleteByUserId() with true");
                return true;
            }else{
                Log::info("Exit MemberDataService.deleteByUserId() with false");
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
     * findByGroupId method find member with matched group id in database
     * @param $group_id
     * @throws DatabaseException
     * @return \App\Model\User[]|array
     */
    function findByGroupId($group_id){
        Log::info("Entering MemberDataService::findByGroupId()");
        
        try{
            
            // Select member with mtached group id
            $statement = $this->connection->prepare("SELECT AFFINITY_GROUP_ID, USER_ID FROM MEMBER WHERE AFFINITY_GROUP_ID = :group_id ");
            
            if(!$statement){
                echo "Something wrong in the binding process.sql error?";
                exit;
            }
            //bindParam $id
            $statement->bindParam(':group_id', $group_id);
            $statement->execute();
            
            //if finds result, fetch user inoformation and returns in users array
            if($statement->rowCount() > 0){
                $index = 0;
                $users = array();
                
                while($row = $statement->fetch(PDO::FETCH_ASSOC))
                {
                    $user = new User($row['USER_ID'], "", "", "", "", "", "", "", "", "");
                    $users[$index++] = $user;
                }
                    return $users;
            }else{
                //else returns empty array
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
     * findByUserId method finds member with matched user id in database
     * @param $user_id
     * @throws DatabaseException
     * @return array|\App\Model\Group|array
     */
    function findByUserId($user_id){
        Log::info("Entering MemberDataService::findByUserId()");
        
        try{
            
            $statement = $this->connection->prepare("SELECT AFFINITY_GROUP_ID, USER_ID FROM MEMBER WHERE USER_ID = :user_id ");
            
            if(!$statement){
                echo "Something wrong in the binding process.sql error?";
                exit;
            }
            //bindParam $id
            $statement->bindParam(':user_id', $user_id);
            $statement->execute();
       
            //if finds result, fetch group information and returns in groups array            
            if($statement->rowCount() > 0){
                $index = 0;
                $group = array();
                
                while($row = $statement->fetch(PDO::FETCH_ASSOC))
                {
                    $group = new Group($row['AFFINITY_GROUP_ID'], "", "", "");
                    $groups[$index++] = $group;
                }
                
                return $groups;
            
            // else return empty array
            }else{
                
                return array();
            }
            
        }catch(PDOException $e)
        {
            // catch exception and throw DatabaseException
            Log::error("Exception: ", array("message " => $e->getMessage()));
            throw new DatabaseException("Database Exception: ". $e->getMessage(), 0, $e);
        }
    }
}

