<?php
/* CLC Project version 4.0
 * MemberBusinessService version 4.0
 * Adam Bender and Jim Nguyen
 * March 8, 2020
 * MemberBusinessService handles CRUD methods
 */
namespace App\Services\Business;

use App\Database\Database;
use Illuminate\Support\Facades\Log;
use App\Services\Data\MemberDataService;

class MemberBusinessService
{
    /**
     * createMember method calls and passes $member to createMember method in MemberDataService
     * @param $member
     * @return boolean
     */
    function createMember($member)
    {
        Log::info("Entering MemberBusinessService.createMember()");
        
        // create connection to database
        $database = new Database();
        $db = $database->getConnection();
        
        // Create a Group Data Service with this connection and calls createGroup method/
        $dbService = new MemberDataService($db);
        $flag = $dbService->createMember($member);
        
        // close the connection
        $db = null;
        
        // return the finder result
        Log::info("Exit GroupBusinessService.createMember() ");
        return $flag;
    }
    
    /**
     * deleteMember method calls and passes $member to deleteMember method in MemberDataService
     * @param $member
     * @return boolean
     */
    function deleteMember($member){
        
        Log::info("Entering MemberBusinessService.deleteMember() ");
        
        //create connection to database
        $database = new Database();
        $db = $database->getConnection();
        
        // Create a Group Data Service with this connection and calls deleteGroup method/
        $dbService = new MemberDataService($db);
        $flag = $dbService->deleteMember($member);
        
        // close the connection
        $db = null;
        
        // return the finder result
        Log::info("Exit MemberBusinessService.deleteMember() ");
        return $flag;
    }
    
    /**
     * deleteByGroupId method calls and passes $group_id to deleteByGroupId method in MemberDataService
     * @param $group_id
     * @return boolean
     */
    function deleteByGroupId($group_id){
        
        Log::info("Entering MemberBusinessService.deleteByGroupId() ");
        
        //create connection to database
        $database = new Database();
        $db = $database->getConnection();
        
        // Create a Group Data Service with this connection and calls deleteGroup method/
        $dbService = new MemberDataService($db);
        $flag = $dbService->deleteByGroupId($group_id);
        
        // close the connection
        $db = null;
        
        // return the finder result
        Log::info("Exit MemberBusinessService.deleteMember() ");
        return $flag;
    }
    
    /**
     * findByGroupId method calls and passes $group_id to findByGroupId method in MemberDataService
     * @param $group_id
     * @return array|\App\Model\User[]
     */
    function findByGroupId($group_id){
        
        Log::info("Entering MemberBusinessService.findByGroupId() ");
        
        $database = new Database();
        $db = $database->getConnection();
        
        // Create a Member Data Service with this connection and calls findAllMembers method/
        $dbService = new MemberDataService($db);
        $flag = $dbService->findByGroupId($group_id);
        
        // close the connection
        $db = null;
        
        // return the finder result
        Log::info("Exit MemberBusinessService.findByGroupId() ");
        return $flag;
    }
    
    /**
     * findByUserId method calls and passes $user_id to findByUserId method in MemberDataService
     * @param $user_id
     * @return array|\App\Model\Group
     */
    function findByUserId($user_id){
        
        Log::info("Entering MemberBusinessService.findByUserId() ");
        
        $database = new Database();
        $db = $database->getConnection();
        
        // Create a Member Data Service with this connection and calls findAllMembers method/
        $dbService = new MemberDataService($db);
        $flag = $dbService->findByUserId($user_id);
        
        // close the connection
        $db = null;
        
        // return the finder result
        Log::info("Exit MemberBusinessService.findByUserId() ");
        return $flag;
    }
}


