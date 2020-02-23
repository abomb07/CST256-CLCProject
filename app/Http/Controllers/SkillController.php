<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Skill;
use App\Services\Business\SkillBusinessService;
use App\Services\Business\EducationBusinessService;
use App\Services\Business\JobHistoryBusinessService;
use Validator;

class SkillController extends Controller
{
    // add a Skill
    public function createSkill(Request $request)
    {
        //validate form
        $this->validateSkillForm($request);
        
        //Get posted form data
        $skill = $request->input('skill');
        $user_id = $request->input('user_id');
        $skill = new Skill(0, $skill, $user_id);
     
        $jhbs = new JobHistoryBusinessService();
        $sbs = new SkillBusinessService();
        $eds = new EducationBusinessService();
        if($result = $sbs->createSkill($skill)){
            
            $jobhistorys = $jhbs->findByUserId($user_id);
            $skills = $sbs->findByUserId($user_id);
            $educations = $eds->findByUserId($user_id);
            
            return view(('userPortfolio'),compact(['jobhistorys'],['skills'], ['educations']));
        }
    }
    // processDeleteSkill method handles data from editSkillForm
    // and pass it to processDeleteSkill method in SkillBusinessService
    public function processDelete(Request $request)
    {
        //Get posted Form data
        $id = $request->input('id');
        
        
        $sbs = new SkillBusinessService();
        
        // calls findById method in UserBusinessService and passes User Object
        $skill = $sbs->findById($id);
        
        return view('userPortfolioDeleteSkill')->with(compact('skill'));
        
    }
    
    // openUpdateSkill method handles data from portfolio
    // and pass it to findById method in SkillBusinessService
    public function openUpdateSkill(Request $request){
        
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
        
    }
    
    // deleteSkill method handles data
    // and pass it to deleteJob method in SkillBusinessService
    public function deleteSkill(Request $request)
    {
        //Get posted Form data
        $id = $request->input('id');
        $user_id = $request->input('user_id');
        
        //Save posted Form Data to Skill Object Model
        $theSkill = new Skill($id, "", "");
        $sbs = new SkillBusinessService();
        $jhbs = new JobHistoryBusinessService();
        $eds = new EducationBusinessService();
        
        // calls deleteUser method in SkillBusinessService and passes Skill Object
        $result = $sbs->deleteSkill($theSkill);
        
        //if success, return to homePage, else return error message
        if($result)
        {
            $jobhistorys = $jhbs->findByUserId($user_id);
            $skills = $sbs->findByUserId($user_id);
            $educations = $eds->findByUserId($user_id);
            
            return view(('userPortfolio'),compact(['jobhistorys'],['skills'], ['educations']));
        }
    }
    
    //redirectSkill method handles data from data validation
    //and passes it back to the edit form
    public function redirectSkill($id, $errors)
    {
        
        $sbs = new SkillBusinessService();
        
        // calls findById method in SkillBusinessService and passes Skill Object
        $skill = $sbs->findById($id);
        
        //return to view with model and errors
        return view('userPortfolioEditSkill')->with(compact('skill', 'errors'));
    }
    
    // updateSkill method handles data from editSkillForm
    // and pass it to updateSkill method in SkillBusinessService
    public function updateSkill(Request $request)
    {
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
            return $this->redirectSkill($id, $errors);
        }
        
        //Save posted Form Data to Skill Object Model
        $updatedSkill = new Skill($id, $skill, $user_id);
        
        // calls update method in SkillBusinessService and passes Skill Object
        $jhbs = new JobHistoryBusinessService();
        $sbs = new SkillBusinessService();
        $eds = new EducationBusinessService();
        $result = $sbs->updateSkill($updatedSkill);
        
        // if success returns to homePage, else returns error message
        if($result)
        {
            $jobhistorys = $jhbs->findByUserId($user_id);
            $skills = $sbs->findByUserId($user_id);
            $educations = $eds->findByUserId($user_id);
            
            return view(('userPortfolio'),compact(['jobhistorys'],['skills'], ['educations']));
        }
    }

    /* validateSkillForm method handles data validation in New Skill Form
     */
    private function validateSkillForm(Request $request){
        
        // data validation rules for Register Form
        $rules = ['skill'=> 'Required|max:256',
        ];
        
        // Run Data Validation Rules
        $this->validate($request, $rules);
    }
}
