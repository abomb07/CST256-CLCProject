<?php
/*
 * CLC Project version 3.0
 * Job History Controller version 3.0
 * Adam Bender and Jim Nguyen
 * February 23, 2020
 * Job History Controller handles job history functionalities
 */
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\JobHistory;
use App\Services\Business\SkillBusinessService;
use App\Services\Business\EducationBusinessService;
use App\Services\Business\JobHistoryBusinessService;
use Validator;
class JobHistoryController extends Controller
{
    
    // createJobHistory method handles data from New Job History Form
    public function createJobHistory(Request $request)
    {
        $this->validateJobHistoryForm($request);
        //Get posted form data
        $title = $request->input('title');
        $company = $request->input('company');
        $startdate = $request->input('startdate');
        $enddate = $request->input('enddate');
        $user_id = $request->input('user_id');
        
        
        $jobhistory = new JobHistory(0, $title, $company, $startdate, $enddate, $user_id);
        $jhbs = new JobHistoryBusinessService();
        $sbs = new SkillBusinessService();
        $eds = new EducationBusinessService();
        
        if($result = $jhbs->createJobHistory($jobhistory)){

            $jobhistorys = $jhbs->findByUserId($user_id);
            $skills = $sbs->findByUserId($user_id);
            $educations = $eds->findByUserId($user_id);
            
            return view(('userPortfolio'),compact(['jobhistorys'],['skills'], ['educations']));
        }
    }
    // processDeleteJobHistory method handles data
    // and pass it to processDeleteJobHistory method in JobHistoryBusinessService
    public function processDelete(Request $request)
    {
        //Get posted Form data
        $id = $request->input('id');
        
        
        $jhbs = new JobHistoryBusinessService();
        
        // calls findById method in UserBusinessService and passes User Object
        $jobhistory = $jhbs->findById($id);
        
        return view('userPortfolioDeleteJobHistory')->with(compact('jobhistory'));
        
    }
    
    // deleteJob method handles data from adminUser
    // and pass it to deleteJob method in JobBusinessService
    public function deleteJobHistory(Request $request)
    {
        //Get posted Form data
        $id = $request->input('id');
        $user_id = $request->input('user_id');
        
        //Save posted Form Data to User Object Model
        $theJob = new JobHistory($id, "", "", "", "", "");
        $jhbs = new JobHistoryBusinessService();
        $sbs = new SkillBusinessService();
        $eds = new EducationBusinessService();
        
        // calls deleteJobHistory method in UserBusinessService and passes User Object
        $result = $jhbs->deleteJobHistory($theJob);
        
        
        //if success, return to homePage, else return error message
        if($result)
        {
            $jobhistorys = $jhbs->findByUserId($user_id);
            $skills = $sbs->findByUserId($user_id);
            $educations = $eds->findByUserId($user_id);
            
            return view(('userPortfolio'),compact(['jobhistorys'],['skills'], ['educations']));
        }
        else
        {
            return "Unable to delete job history. Please try again!";
        }
    }
    
    // openUpdateJobHistory method handles data from editJobForm
    // and pass it to findById method in JobHistoryBusinessService
    public function openUpdateJobHistory(Request $request){
        
        //Get posted Form data
        $id = $request->input('id');
        
        //Save posted Form Data to Job History Object Model
        
        $jbs = new JobHistoryBusinessService();
        
        // calls findById method in JobHistoryBusinessService and passes Job History Object
        if($jobhistory = $jbs->findById($id)){
            
            return view('userPortfolioEditJobHistory')->with(compact('jobhistory'));
        }else{
            return "Job history not found. Please try again";
        }
        
    }
    
    //redirectJobHistory method handles data from data validation
    //and passes it back to the edit form
    public function redirectJobHistory($id, $errors)
    {
        
        $jhbs = new JobHistoryBusinessService();
        
        // calls findById method in JobHistoryBusinessService and passes JobHistory Object
        $jobhistory = $jhbs->findById($id);
        
        //return to view with model and errors
        return view('userPortfolioEditJobHistory')->with(compact('jobhistory', 'errors'));
    }
    
    // updateJobHistory method handles data from userPortfolioEditJobHistory
    // and pass it to updateJobHistory method in JobHistoryBusinessService
    public function updateJobHistory(Request $request)
    {
        //Get posted form data
        $id = $request->input('id');
        $title = $request->input('title');
        $company = $request->input('company');
        $startdate = $request->input('startdate');
        $enddate = $request->input('enddate');
        $user_id = $request->input('user_id');
        
        //Make validator rules
        $validator = Validator::make($request->all(), ['id' => 'Required',
            'title'=> 'Required|max:256',
            'company' => 'Required|max:256',
            'startdate' => 'Required',
            'enddate' => 'Required',
            'user_id' => 'Required'
            
        ]);
        
        //if there is a validation error, reroute to form with errors and model
        if($validator->fails())
        {
            $errors = $validator->errors();
            return $this->redirectJobHistory($id, $errors);
        }
        
        //Save posted Form Data to Job History Object Model
        $updatedJobHistory = new JobHistory($id, $title, $company, $startdate, $enddate, $user_id);
        
        // calls findById method in JobHistoryBusinessService and passes Job History Object
       
        $jhbs = new JobHistoryBusinessService();
        $sbs = new SkillBusinessService();
        $eds = new EducationBusinessService();
        $result = $jhbs->updateJobHistory($updatedJobHistory);
        
        // if success returns to userPortfolio, else returns error message
        if($result)
        {
            $jobhistorys = $jhbs->findByUserId($user_id);
            $skills = $sbs->findByUserId($user_id);
            $educations = $eds->findByUserId($user_id);
            
            return view(('userPortfolio'),compact(['jobhistorys'],['skills'], ['educations']));
        }
        else
        {
            return "Update job history unsuccessfully. Please try again";
        }
    }
    
    
    /* validateJobHistoryForm method handles data validation in New Job History Form
     */
    private function validateJobHistoryForm(Request $request){
        
        // data validation rules for Register Form
        $rules = ['title'=> 'Required|max:256',
            'company' => 'Required|max:256',
            'startdate' => 'Required',
            'enddate' => 'Required',
        ];
        
        // Run Data Validation Rules
        $this->validate($request, $rules);
    }
    
}
