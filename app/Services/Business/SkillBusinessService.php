<?php
namespace App\Services\Business;

use Illuminate\Support\Facades\Log;
use App\Database\Database;
use App\Services\Data\SkillDataService;

class SkillBusinessService
{
    /* createSkill method calls and passes $user to createSkill method in UserDataService*/
    function createSkill($skill){
        
        Log::info("Entering SkillBusinessService.createSkill()");
        
        // create connection to database
        $database = new Database();
        $db = $database->getConnection();
        
        $dbService = new SkillDataService($db);
        $flag = $dbService->createSkill($skill);
        
        // close the connection
        $db = null;
        
        // return the finder result
        Log::info("Exit SkillBusinessService.createSkill() ");
        return $flag;
    }
    
    /* deleteSkill method calls and passes $user to deleteSkill method in SkillDataService*/
    function deleteSkill($skill){
        
        Log::info("Entering SkillBusinessService.deleteSkill()");
        
        //create connection to database
        $database = new Database();
        $db = $database->getConnection();
        
        // Create a Skill Data Service with this connection and calls deleteSkill method/
        $dbService = new SkillDataService($db);
        $flag = $dbService->deleteSkill($skill);
        
        // close the connection
        $db = null;
        
        // return the finder result
        Log::info("Exit SkillBusinessService.deleteSkill() ");
        return $flag;
    }
    
    /* updateSkill method calls and passes $user to updateSkill method in SkillDataService*/
    function updateSkill($skill){
        
        Log::info("Entering SkillBusinessService.updateSkill()");
        
        $database = new Database();
        $db = $database->getConnection();
        
        // Create a Skill Data Service with this connection and calls updateUser method/
        $dbService = new SkillDataService($db);
        $flag = $dbService->updateSkill($skill);
        
        // close the connection
        $db = null;
        
        // return the finder result
        Log::info("Exit SkillBusinessService.updateSkill() ");
        return $flag;
    }
    
    /* findAllSkills method calls and passes $user to updateSkill method in SkillDataService*/
    function findById($id){
        
        Log::info("Entering SkillBusinessService.findByUserId()");
        
        $database = new Database();
        $db = $database->getConnection();
        
        // Create a Skill Data Service with this connection and calls updateUser method/
        $dbService = new SkillDataService($db);
        $flag = $dbService->findById($id);
        
        // close the connection
        $db = null;
        
        // return the finder result
        Log::info("Exit SkillBusinessService.findById() ");
        return $flag;
    }
    
    /* findAllSkills method calls and passes $user to updateSkill method in SkillDataService*/
    function findByUserId($user_id){
        
        Log::info("Entering SkillBusinessService.findByUserId()");
        
        $database = new Database();
        $db = $database->getConnection();
        
        // Create a Skill Data Service with this connection and calls updateUser method/
        $dbService = new SkillDataService($db);
        $flag = $dbService->findByUserId($user_id);
        
        // close the connection
        $db = null;
        
        // return the finder result
        Log::info("Exit SkillBusinessService.findByUser() ");
        return $flag;
    }
       
}

