<?php
namespace App\Services\Business;

use App\Model\Member;

use App\Database\Database;
use Illuminate\Support\Facades\Log;
use App\Services\Data\MemberDataService;

class MemberBusinessService
{
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
    
    /* deleteMember method calls and passes $group to deleteMember method in GroupDataService*/
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
    
    /* findAllMembers method calls and passes $job to findAllJobs method in GroupDataService*/
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
    
    /* findByUserId method calls and passes $job to findAllJobs method in GroupDataService*/
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


