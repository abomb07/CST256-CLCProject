<?php
/* CLC Project version 6.0
 * GroupBusinessService version 6.0
 * Adam Bender and Jim Nguyen
 * April 5, 2020
 * GroupBusinessService handles CRUD methods
 */

namespace App\Services\Business;

use App\Database\Database;
use App\Services\Data\GroupDataService;
use App\Services\Data\MemberDataService;
use Illuminate\Support\Facades\Log;

class GroupBusinessService
{
    /**
     * addGroup method calls and passes $group to createGroup method in GroupDataService
     * @param $group
     * @return boolean
     */
    function addGroup($group){
        Log::info("Entering GroupBusinessService.createGroup()");
        
        // create connection to database
        $database = new Database();
        $db = $database->getConnection();
        
        // Create a Group Data Service with this connection and calls createGroup method/
        $dbService = new GroupDataService($db);
        $flag = $dbService->createGroup($group);
        
        // close the connection
        $db = null;
        
        // return the finder result
        Log::info("Exit GroupBusinessService.createGroup() ");
        return $flag;
    }
    
    /**
     * deleteGroup method calls and passes $group to deleteGroup method in GroupDataService
     * @param $group
     * @return boolean
     */
    function deleteGroup($group){
        
        Log::info("Entering GroupBusinessService.deleteGroup() ");
        
        //create connection to database
        $database = new Database();
        $db = $database->getConnection();
        
        // Create a Group Data Service with this connection and calls deleteGroup method/
        $dbService = new GroupDataService($db);
        $flag = $dbService->deleteGroup($group);
        
        // close the connection
        $db = null;
        
        // return the finder result
        Log::info("Exit GroupBusinessService.deleteGroup() ");
        return $flag;
    }
    
    /**
     * editGroup method calls and passes $group to updateGroup method in GroupDataService
     * @param $group
     * @return boolean
     */
    function editGroup($group){
        
        Log::info("Entering GroupBusinessService.updateGroup() ");
        
        $database = new Database();
        $db = $database->getConnection();
        
        // Create a Group Data Service with this connection and calls updateGroup method/
        $dbService = new GroupDataService($db);
        $flag = $dbService->updateGroup($group);
        
        // close the connection
        $db = null;
        
        // return the finder result
        Log::info("Exit GroupBusinessService.updateGroup() ");
        return $flag;
    }
    
    /**
     * findAllGroups method calls and passes $job to findAllJobs method in GroupDataService
     * @return array
     */
    function findAllGroups(){
        
        Log::info("Entering GroupBusinessService.findAllGroups() ");
        
        $database = new Database();
        $db = $database->getConnection();
        
        // Create a Group Data Service with this connection and calls findAllGroups method/
        $dbService = new GroupDataService($db);
        $flag = $dbService->findAllGroups();
        
        // close the connection
        $db = null;
        
        // return the finder result
        Log::info("Exit GroupBusinessService.findAllGroups() ");
        return $flag;
    }
    
    /**
     * findById method calls and passes $job to findById method in GroupDataService
     * @param $id
     * @return \App\Model\Group
     */
    function findById($id){
        
        Log::info("Entering GroupBusinessService.findById()");
        
        $database = new Database();
        $db = $database->getConnection();
        
        // Create a Group Data Service with this connection and calls findById method/
        $dbService = new GroupDataService($db);
        $flag = $dbService->findById($id);
        
        // close the connection
        $db = null;
        
        // return the finder result
        Log::info("Exit GroupBusinessService.findById() ");
        return $flag;
    }
    
    /**
     * findByGroupName method calls and passes $job to findByGroupName method in GroupDataService
     * @param $name
     * @return \App\Model\Group
     */
    function findByGroupName($name){
        
        Log::info("Entering GroupBusinessService.findByGroupName()");
        
        $database = new Database();
        $db = $database->getConnection();
        
        // Create a Group Data Service with this connection and calls findByGroupName method/
        $dbService = new GroupDataService($db);
        $flag = $dbService->findByGroupName($name);
        
        // close the connection
        $db = null;
        
        // return the finder result
        Log::info("Exit GroupBusinessService.findByGroupName() ");
        return $flag;
    }
    
    /* ================================== MEMBER FUNCTIONS =================================== *\
    
    /**
     * joinGroup method calls and passes $member to createMember method in MemberDataService
     * @param $member
     * @return boolean
     */
    function joinGroup($member)
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
     * leaveGroup method calls and passes $member to deleteMember method in MemberDataService
     * @param $member
     * @return boolean
     */
    function leaveGroup($member){
        
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
     * deleteGroupMembers method calls and passes $group_id to deleteByGroupId method in MemberDataService
     * @param $group_id
     * @return boolean
     */
    function deleteGroupMembers($group_id){
        
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
     * leaveAllGroups method calls and passes $user_id to deleteByUserId method in MemberDataService
     * @param $group_id
     * @return boolean
     */
    function leaveAllGroups($user_id){
        
        Log::info("Entering MemberBusinessService.leaveAllGroups() ");
        
        //create connection to database
        $database = new Database();
        $db = $database->getConnection();
        
        // Create a Group Data Service with this connection and calls deleteGroup method/
        $dbService = new MemberDataService($db);
        $flag = $dbService->deleteByUserId($user_id);
        
        // close the connection
        $db = null;
        
        // return the finder result
        Log::info("Exit MemberBusinessService.leaveAllGroups() ");
        return $flag;
    }
    
    /**
     * findAllMembers method calls and passes $group_id to findByGroupId method in MemberDataService
     * @param $group_id
     * @return array|\App\Model\User[]
     */
    function findAllMembers($group_id){
        
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
     * findGroupsByUserId method calls and passes $user_id to findByUserId method in MemberDataService
     * @param $user_id
     * @return array|\App\Model\Group
     */
    function findGroupsByUserId($user_id){
        
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