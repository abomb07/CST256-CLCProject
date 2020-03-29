<?php
/* CLC Project version 5.0
 * SkillBusinessService version 5.0
 * Adam Bender and Jim Nguyen
 * March 15, 2020
 * SkillBusinessService handles CRUD methods
 */
namespace App\Services\Business;

use Illuminate\Support\Facades\Log;
use App\Database\Database;
use App\Services\Data\SkillDataService;

class SkillBusinessService
{
    /**
     * addSkill method calls and passes $skill to createSkill method in SkillDataService
     * @param $skill
     * @return boolean
     */
    function addSkill($skill){
        
        Log::info("Entering SkillBusinessService.addSkill()");
        
        // create connection to database
        $database = new Database();
        $db = $database->getConnection();
        
        $dbService = new SkillDataService($db);
        $flag = $dbService->createSkill($skill);
        
        // close the connection
        $db = null;
        
        // return the finder result
        Log::info("Exit SkillBusinessService.addSkill() ");
        return $flag;
    }
    
    /**
     * deleteSkill method calls and passes $skill to deleteSkill method in SkillDataService
     * @param $skill
     * @return boolean
     */
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
    
    /**
     * editSkill method calls and passes $skill to updateSkill method in SkillDataService
     * @param $skill
     * @return boolean
     */
    function editSkill($skill){
        
        Log::info("Entering SkillBusinessService.updateSkill()");
        
        $database = new Database();
        $db = $database->getConnection();
        
        // Create a Skill Data Service with this connection and calls updateSkill method/
        $dbService = new SkillDataService($db);
        $flag = $dbService->updateSkill($skill);
        
        // close the connection
        $db = null;
        
        // return the finder result
        Log::info("Exit SkillBusinessService.editSkill() ");
        return $flag;
    }
    
    /**
     * findById method calls and passes $id to findById method in SkillDataService
     * @param $id
     * @return \App\Model\Skill
     */
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
    
    /**
     * findSkillByUserId method calls and passes $user_id to findByUserId method in SkillDataService
     * @param $user_id
     * @return array
     */
    function findSkillByUserId($user_id){
        
        Log::info("Entering SkillBusinessService.findSkillByUserId()");
        
        $database = new Database();
        $db = $database->getConnection();
        
        // Create a Skill Data Service with this connection and calls updateUser method/
        $dbService = new SkillDataService($db);
        $flag = $dbService->findByUserId($user_id);
        
        // close the connection
        $db = null;
        
        // return the finder result
        Log::info("Exit SkillBusinessService.findSkillByUserId() ");
        return $flag;
    }
       
}

