<?php
/* CLC Project version 4.0
 * UserDataService version 4.0
 * Adam Bender and Jim Nguyen
 * March 8th, 2020
 * GroupDataService handle methods through MySQL Statement
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
    
    
    public function __construct($connection){
        $this->connection = $connection;
    }
    
    //createMember method connects to database and add new member information into SQL statement
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
            
            
            $statement->bindParam(':group_id', $group_id, PDO::PARAM_STR);
            $statement->bindParam(':user_id', $user_id, PDO::PARAM_STR);           
            
            
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
    
    //deleteMember method connects database and delete member using MySQL statement
    function deleteMember(Member $member){
        Log::info("Entering MemberDataService::deleteMember()");
        try{
            $statement = $this->connection->prepare("DELETE FROM MEMBER WHERE USER_ID = :user_id AND AFFINITY_GROUP_ID = :group_id");
            
            if(!$statement){
                echo "Something wrong in the binding process.sql error?";
                exit;
            }
            
            $user_id = $member->getUser_id();
            $group_id = $member->getGroup_id();
            
            $statement->bindParam(':user_id',  $user_id, PDO::PARAM_INT);
            $statement->bindParam(':group_id',  $group_id, PDO::PARAM_INT);
            $statement->execute();
            
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
    
    // findByGroupId method find user with matched id in database
    function findByGroupId($group_id){
        Log::info("Entering MemberDataService::findByGroupId()");
        
        try{
            
            $statement = $this->connection->prepare("SELECT AFFINITY_GROUP_ID, USER_ID FROM MEMBER WHERE AFFINITY_GROUP_ID = :group_id ");
            
            if(!$statement){
                echo "Something wrong in the binding process.sql error?";
                exit;
            }
            //bindParam $id
            $statement->bindParam(':group_id', $group_id);
            $statement->execute();
            
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
                return array();
            }
            
        }catch(PDOException $e)
        {
            // catch exception and throw DatabaseException
            Log::error("Exception: ", array("message " => $e->getMessage()));
            throw new DatabaseException("Database Exception: ". $e->getMessage(), 0, $e);
        }
    }
    
    // findByUserId method find group with matched id in database
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
            
            if($statement->rowCount() > 0){
                $index = 0;
                $group = array();
                
                while($row = $statement->fetch(PDO::FETCH_ASSOC))
                {
                    $group = new Group($row['AFFINITY_GROUP_ID'], "", "", "");
                    $groups[$index++] = $group;
                }
                
                return $groups;
                
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

