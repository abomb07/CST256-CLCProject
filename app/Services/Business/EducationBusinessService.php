<?php
/* CLC Project version 5.0
 * EducationBusinessService version 5.0
 * Adam Bender and Jim Nguyen
 * March 15, 2020
 * EducationBusinessService handles CRUD methods
 */
namespace App\Services\Business;

use Illuminate\Support\Facades\Log;
use App\Database\Database;
use App\Services\Data\EducationDataService;
class EducationBusinessService
{
    /**
     * addEducation method calls and passes $education to createEducation method in EducationDataService
     * @param $education
     * @return boolean
     */
    function addEducation($education){
        
        Log::info("Entering EducationBusinessService.createEducation()");
        
        // create connection to database
        $database = new Database();
        $db = $database->getConnection();
        
        $dbService = new EducationDataService($db);
        $flag = $dbService->createEducation($education);
        
        // close the connection
        $db = null;
        
        // return the finder result
        Log::info("Exit EducationBusinessService.createEducation()");
        return $flag;
    }
    
    /**
     * deleteEducation method calls and passes $education to call deleteEducation method in EducationDataService
     * @param $education
     * @return boolean
     */
    function deleteEducation($education){
        
        Log::info("Entering EducationBusinessService.deleteEducation()");
        
        //create connection to database
        $database = new Database();
        $db = $database->getConnection();
        
        // Create a Education Data Service with this connection and calls deleteEducation method/
        $dbService = new EducationDataService($db);
        $flag = $dbService->deleteEducation($education);
        
        // close the connection
        $db = null;
        
        // return the finder result
        Log::info("Exit EducationBusinessService.deleteEducation() ");
        return $flag;
    }
    
    /**
     * editEducation method calls and passes $user to updateEducation method in EducationDataService
     * @param $education
     * @return boolean
     */
    function editEducation($education){
        
        Log::info("Entering EducationBusinessService.updateSkill()");
        
        $database = new Database();
        $db = $database->getConnection();
        
        // Create a Education Data Service with this connection and calls updateEducation method/
        $dbService = new EducationDataService($db);
        $flag = $dbService->updateEducation($education);
        
        // close the connection
        $db = null;
        
        // return the finder result
        Log::info("Exit EducationBusinessService.updateEducation()  ");
        return $flag;
    }
    
    /**
     * findEducationByUserId method calls and passes $user to findByUserId method in SkillDataService
     * @param $user_id
     * @return object
     */
    function findEducationByUserId($user_id){
        
        Log::info("Entering EducationBusinessService.findByUserId()");
        
        $database = new Database();
        $db = $database->getConnection();
        
        // Create a Education Data Service with this connection and calls findByUserId method/
        $dbService = new EducationDataService($db);
        $flag = $dbService->findByUserId($user_id);
        
        // close the connection
        $db = null;
        
        // return the finder result
        Log::info("Exit EducationBusinessService.findByUserId() ");
        return $flag;
    }
    
    /**
     * findById method calls and passes $user to findById method in EducationDataService
     * @param $id
     * @return \App\Model\Education
     */
    function findById($id){
        
        Log::info("Entering EducationBusinessService.findById()");
        
        $database = new Database();
        $db = $database->getConnection();
        
        // Create a Education Data Service with this connection and calls findById method/
        $dbService = new EducationDataService($db);
        $flag = $dbService->findById($id);
        
        // close the connection
        $db = null;
        
        // return the finder result
        Log::info("Exit EducationBusinessService.findById() ");
        return $flag;
    }
       
}

