<?php
/* CLC Project version 4.0
 * SkillController version 4.0
 * Adam Bender and Jim Nguyen
 * March 8, 2020
 * SkillController handles user profile action
 */
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use App\Model\Skill;
use App\Services\Business\SkillBusinessService;
use App\Services\Business\EducationBusinessService;
use App\Services\Business\JobHistoryBusinessService;
use App\Services\Business\GroupBusinessService;
use App\Services\Business\MemberBusinessService;
use Exception;
use Validator;

class SkillController extends Controller
{
    /**
     * add a Skill
     * @param Request $request
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function createSkill(Request $request)
    {
        try{
            //validate form
            $this->validateSkillForm($request);
            
            //Get posted form data
            $skill = $request->input('skill');
            $user_id = $request->input('user_id');
            $skill = new Skill(0, $skill, $user_id);
         
            $jhbs = new JobHistoryBusinessService();
            $sbs = new SkillBusinessService();
            $eds = new EducationBusinessService();
            $gbs = new GroupBusinessService();
            $mbs = new MemberBusinessService();
            
            if($result = $sbs->createSkill($skill)){
                
                $groups = $mbs->findByUserId($user_id);
                $jobhistorys = $jhbs->findByUserId($user_id);
                $skills = $sbs->findByUserId($user_id);
                $educations = $eds->findByUserId($user_id);
                
                if($groups)
                {
                    for ($i = 0; $i < count($groups); $i++) {
                        $groupNames[$i] = $gbs->findById($groups[$i]->getId());
                    }
                }
                else
                {
                    $groupNames = array();
                }
                
                // return to userPortfolio Form with jobhistorys, skills, educations objects
                return view(('userPortfolio'),compact(['jobhistorys'],['skills'], ['educations'], ['groupNames']));
            }
        }catch(ValidationException $e1){
            throw ($e1);
        }catch(Exception $e2){
            Log::info("Exception ". array("message" => $e2->getMessage()));
            //Display Global Namespace Handler Page
            return view('SystemException');
        }
    }
    
    /**
     * processDelete method handles data from editSkillForm
     * and pass it to processDeleteSkill method in SkillBusinessService
     * @param Request $request
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function processDelete(Request $request)
    {
        try{
            //Get posted Form data
            $id = $request->input('id');
            
            
            $sbs = new SkillBusinessService();
            
            // calls findById method in UserBusinessService and passes User Object
            $skill = $sbs->findById($id);
            
            return view('userPortfolioDeleteSkill')->with(compact('skill'));
        
        }catch(Exception $e2){
            Log::info("Exception ". array("message" => $e2->getMessage()));
            //Display Global Namespace Handler Page
            return view('SystemException');
        }
        
    }
    
    /**
     * openUpdateSkill method handles data from portfolio
     * and pass it to findById method in SkillBusinessService
     * @param Request $request
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory|string
     */
    public function openUpdateSkill(Request $request){
        try{
            //Get posted Form data
            $id = $request->input('id');
            
            //Save posted Form Data to Skill Object Model
            
            $sbs = new SkillBusinessService();
            
            // calls findById method in JobHistoryBusinessService and passes Job History Object
            if($skill = $sbs->findById($id)){
                
                return view('userPortfolioEditSkill')->with(compact('skill'));
            }else{
                return "Skill not found. Please try again";
            }
        
        }catch(Exception $e2){
            Log::info("Exception ". array("message" => $e2->getMessage()));
            //Display Global Namespace Handler Page
            return view('SystemException');
        }
        
    }
    
    /**
     * deleteSkill method handles data
     * and pass it to deleteJob method in SkillBusinessService
     * @param Request $request
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function deleteSkill(Request $request)
    {
        try{
            //Get posted Form data
            $id = $request->input('id');
            $user_id = $request->input('user_id');
            
            //Save posted Form Data to Skill Object Model
            $theSkill = new Skill($id, "", "");
            $sbs = new SkillBusinessService();
            $jhbs = new JobHistoryBusinessService();
            $eds = new EducationBusinessService();
            $gbs = new GroupBusinessService();
            $mbs = new MemberBusinessService();
            
            // calls deleteUser method in SkillBusinessService and passes Skill Object
            $result = $sbs->deleteSkill($theSkill);
            
            //if success, return to homePage, else return error message
            if($result)
            {
                $groups = $mbs->findByUserId($user_id);
                $jobhistorys = $jhbs->findByUserId($user_id);
                $skills = $sbs->findByUserId($user_id);
                $educations = $eds->findByUserId($user_id);
                
                if($groups)
                {
                    for ($i = 0; $i < count($groups); $i++) {
                        $groupNames[$i] = $gbs->findById($groups[$i]->getId());
                    }
                }
                else
                {
                    $groupNames = array();
                }
                
                // return to userPortfolio Form with jobhistorys, skills, educations objects
                return view(('userPortfolio'),compact(['jobhistorys'],['skills'], ['educations'], ['groupNames']));
            }
        
        }catch(Exception $e2){
            Log::info("Exception ". array("message" => $e2->getMessage()));
            //Display Global Namespace Handler Page
            return view('SystemException');
        }
    }
    
    /**
     * updateSkill method handles data from editSkillForm
     * and pass it to updateSkill method in SkillBusinessService
     * @param Request $request
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function updateSkill(Request $request)
    {
        try{
            //Get posted form data
            $id = $request->input('id');
            $skill = $request->input('skill');
            $user_id = $request->input('user_id');
            
            //Make validator rules
            $validator = Validator::make($request->all(), ['id' => 'Required',
                'skill'=> 'Required|max:256',
                'user_id' => 'Required'
            ]);
            
            //if there is a validation error, reroute to form with errors and model
            if($validator->fails())
            {
                $errors = $validator->errors();
                $sbs = new SkillBusinessService();
                
                // calls findById method in SkillBusinessService and passes Skill Object
                $skill = $sbs->findById($id);
                
                //return to view with model and errors
                return view('userPortfolioEditSkill')->with(compact('skill', 'errors'));
            }
            
            //Save posted Form Data to Skill Object Model
            $updatedSkill = new Skill($id, $skill, $user_id);
            
            // calls update method in SkillBusinessService and passes Skill Object
            $jhbs = new JobHistoryBusinessService();
            $sbs = new SkillBusinessService();
            $eds = new EducationBusinessService();
            $gbs = new GroupBusinessService();
            $mbs = new MemberBusinessService();
            
            $result = $sbs->updateSkill($updatedSkill);
            
            // if success returns to homePage, else returns error message
            if($result)
            {
                $groups = $mbs->findByUserId($user_id);
                $jobhistorys = $jhbs->findByUserId($user_id);
                $skills = $sbs->findByUserId($user_id);
                $educations = $eds->findByUserId($user_id);
                
                if($groups)
                {
                    for ($i = 0; $i < count($groups); $i++) {
                        $groupNames[$i] = $gbs->findById($groups[$i]->getId());
                    }
                }
                else
                {
                    $groupNames = array();
                }
                
                // return to userPortfolio Form with jobhistorys, skills, educations objects
                return view(('userPortfolio'),compact(['jobhistorys'],['skills'], ['educations'], ['groupNames']));
            }
        }catch(ValidationException $e1){
            throw ($e1); 
        }catch(Exception $e2){
            Log::info("Exception ". array("message" => $e2->getMessage()));
            //Display Global Namespace Handler Page
            return view('SystemException');
        }
    }

    /**
     * validateSkillForm method handles data validation in New Skill Form
     * @param Request $request
     */
    private function validateSkillForm(Request $request){
        
        // data validation rules for Register Form
        $rules = ['skill'=> 'Required|max:256',
        ];
        
        // Run Data Validation Rules
        $this->validate($request, $rules);
    }
}
