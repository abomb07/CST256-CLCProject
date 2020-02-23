<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Education;
use App\Services\Business\SkillBusinessService;
use App\Services\Business\EducationBusinessService;
use App\Services\Business\JobHistoryBusinessService;
class EducationController extends Controller
{
    //
    // add a education
    public function createEducation(Request $request)
    {
        //validate form
        $this->validateForm($request);
        
        //Get posted form data
        $school = $request->input('school');
        $degree = $request->input('degree');
        $field = $request->input('field');
        $graduationyear = $request->input('graduationyear');
        $user_id = $request->input('user_id');
        
        $education = new Education(0, $school, $degree, $field, $graduationyear, $user_id);
        
        $jhbs = new JobHistoryBusinessService();
        $sbs = new SkillBusinessService();
        $eds = new EducationBusinessService();
        if($result = $eds->createEducation($education))
        {
            $jobhistorys = $jhbs->findByUserId($user_id);
            $skills = $sbs->findByUserId($user_id);
            $educations = $eds->findByUserId($user_id);
            
            return view(('userPortfolio'),compact(['jobhistorys'],['skills'], ['educations']));
        }
    }
    // processDeleteEducation method handles data from editEducationForm
    // and pass it to processDeleteEducation method in EducationBusinessService
    public function processDelete(Request $request)
    {
        //Get posted Form data
        $id = $request->input('id');
        
        
        $ebs = new EducationBusinessService();
        
        // calls findById method in UserBusinessService and passes User Object
        $education = $ebs->findById($id);
        
        return view('userPortfolioDeleteEducation')->with(compact('education'));
        
    }
    
    // deleteEducation method handles data
    // and pass it to deleteEducation method in EducationBusinessService
    public function deleteEducation(Request $request)
    {
        //Get posted Form data
        $id = $request->input('id');
        $user_id = $request->input('user_id');
        
        //Save posted Form Data to Education Object Model
        $education = new Education($id, "", "", "", "", "");
        $sbs = new SkillBusinessService();
        $jhbs = new JobHistoryBusinessService();
        $eds = new EducationBusinessService();
        
        // calls deleteUser method in EducationBusinessService and passes Education Object
        $result = $eds->deleteEducation($education);
        
        //if success, return to homePage, else return error message
        if($result)
        {
            $jobhistorys = $jhbs->findByUserId($user_id);
            $skills = $sbs->findByUserId($user_id);
            $educations = $eds->findByUserId($user_id);
            
            return view(('userPortfolio'),compact(['jobhistorys'],['skills'], ['educations']));
        }
    }
    // openUpdateEducation method handles data from portfolio
    // and pass it to findById method in EducationBusinessService
    public function openUpdateEducation(Request $request){
        
        //Get posted Form data
        $id = $request->input('id');
        
        //Save posted Form Data to User Object Model
        
        $ebs = new EducationBusinessService();
        
        // calls findById method in UserBusinessService and passes User Object
        if($education = $ebs->findById($id)){
            
            return view('userPortfolioEditEducation')->with(compact('education'));
        }else{
            return "Education not found. Please try again";
        }
        
    }
    
    // updateEducation method handles data from editEducationForm
    // and pass it to updateEducation method in EducationBusinessService
    public function updateEducation(Request $request)
    {
        //validate form
        $this->validateForm($request);
        
        //Get posted form data
        $id = $request->input('id');
        $school = $request->input('school');
        $degree = $request->input('degree');
        $field = $request->input('field');
        $graduationyear = $request->input('graduationyear');
        $user_id = $request->input('user_id');
        
        
        //Save posted Form Data to Skill Object Model
        $updatedEducation = new Education($id, $school, $degree, $field, $graduationyear, $user_id);
        
        // calls update method in SkillBusinessService and passes Skill Object
        $jhbs = new JobHistoryBusinessService();
        $sbs = new SkillBusinessService();
        $eds = new EducationBusinessService();
        $result = $eds->updateEducation($updatedEducation);
        
        // if success returns to homePage, else returns error message
        if($result)
        {
            $jobhistorys = $jhbs->findByUserId($user_id);
            $skills = $sbs->findByUserId($user_id);
            $educations = $eds->findByUserId($user_id);
            
            return view(('userPortfolio'),compact(['jobhistorys'],['skills'], ['educations']));
        }

    }

    private function validateForm(Request $request)
    {
        //BEST PRATICE: centralize your rule so you have a consistent architecture
        //and even resuse your rules
        //BAD PRATICES: not using a defined data validation Framework, putting rules
        //all over your coe, doing only on CLient side and database
        //SEt up data validation for login form
        $rules = ['school'=> 'Required|max:256',
            'degree'=> 'Required|max:256',
            'field'=> 'Required|max:256',
            'graduationyear'=> 'Required|numeric|max:3000'
        ];
        
        // Run Data Validation Rules
        $this->validate($request, $rules);
    }
}
