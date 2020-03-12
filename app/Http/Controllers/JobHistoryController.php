<?php
/*
 * CLC Project version 4.0
 * Job History Controller version 3.0
 * Adam Bender and Jim Nguyen
 * March 8, 2020
 * Job History Controller handles job history functionalities
 */
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use App\Model\JobHistory;
use App\Services\Business\SkillBusinessService;
use App\Services\Business\EducationBusinessService;
use App\Services\Business\JobHistoryBusinessService;
use App\Services\Business\GroupBusinessService;
use App\Services\Business\MemberBusinessService;
use Exception;
use Validator;

class JobHistoryController extends Controller
{
    /**
     * createJobHistory method handles data from New Job History Form
     * @param Request $request
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function createJobHistory(Request $request)
    {
        try
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
            $gbs = new GroupBusinessService();
            
            if($result = $jhbs->addJobHistory($jobhistory)){
    
                $groups = $gbs->findGroupsByUserId($user_id);
                $jobhistorys = $jhbs->findJobHistoryByUserId($user_id);
                $skills = $sbs->findSkillByUserId($user_id);
                $educations = $eds->findEducationByUserId($user_id);
                
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
     * processDelete method handles data
     * and pass it to processDeleteJobHistory method in JobHistoryBusinessService
     * @param Request $request
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function processDelete(Request $request)
    {
        try{
            //Get posted Form data
            $id = $request->input('id');
            
            
            $jhbs = new JobHistoryBusinessService();
            
            // calls findById method in UserBusinessService and passes User Object
            $jobhistory = $jhbs->findById($id);
            
            return view('userPortfolioDeleteJobHistory')->with(compact('jobhistory'));
        
        }catch(Exception $e2){
            Log::info("Exception ". array("message" => $e2->getMessage()));
            //Display Global Namespace Handler Page
            return view('SystemException');
        }
    }
    
    /**
     * deleteJobHistory method handles data from adminUser
     * and pass it to deleteJob method in JobBusinessService
     * @param Request $request
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory|string
     */
    public function deleteJobHistory(Request $request)
    {
        try{
            //Get posted Form data
            $id = $request->input('id');
            $user_id = $request->input('user_id');
            
            //Save posted Form Data to User Object Model
            $theJob = new JobHistory($id, "", "", "", "", "");
            $jhbs = new JobHistoryBusinessService();
            $sbs = new SkillBusinessService();
            $eds = new EducationBusinessService();
            $gbs = new GroupBusinessService();
            
            // calls deleteJobHistory method in UserBusinessService and passes User Object
            $result = $jhbs->deleteJobHistory($theJob);
            
            //if success, return to homePage, else return error message
            if($result)
            {
                $groups = $gbs->findGroupsByUserId($user_id);
                $jobhistorys = $jhbs->findJobHistoryByUserId($user_id);
                $skills = $sbs->findSkillByUserId($user_id);
                $educations = $eds->findEducationByUserId($user_id);
                
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
            else
            {
                return "Unable to delete job history. Please try again!";
            }
        
        }catch(Exception $e2){
            Log::info("Exception ". array("message" => $e2->getMessage()));
            //Display Global Namespace Handler Page
            return view('SystemException');
        }
    }
    
    /**
     * openUpdateJobHistory method handles data from editJobForm
     * and pass it to findById method in JobHistoryBusinessService
     * @param Request $request
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory|string
     */
    public function openUpdateJobHistory(Request $request)
    {
        try{
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
        
        }catch(Exception $e2){
            Log::info("Exception ". array("message" => $e2->getMessage()));
            //Display Global Namespace Handler Page
            return view('SystemException');
        }
        
    }
    
    /**
     * updateJobHistory method handles data from userPortfolioEditJobHistory
     * and pass it to updateJobHistory method in JobHistoryBusinessService
     * @param Request $request
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory|string
     */
    public function updateJobHistory(Request $request)
    {
        try{
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
                $jhbs = new JobHistoryBusinessService();
                
                // calls findById method in JobHistoryBusinessService and passes JobHistory Object
                $jobhistory = $jhbs->findById($id);
                
                //return to view with model and errors
                return view('userPortfolioEditJobHistory')->with(compact('jobhistory', 'errors'));
            }
            
            //Save posted Form Data to Job History Object Model
            $updatedJobHistory = new JobHistory($id, $title, $company, $startdate, $enddate, $user_id);
            
            $jhbs = new JobHistoryBusinessService();
            $sbs = new SkillBusinessService();
            $eds = new EducationBusinessService();
            $gbs = new GroupBusinessService();
            
            $result = $jhbs->editJobHistory($updatedJobHistory);
            
            // if success returns to userPortfolio, else returns error message
            if($result)
            {
                $groups = $gbs->findGroupsByUserId($user_id);
                $jobhistorys = $jhbs->findJobHistoryByUserId($user_id);
                $skills = $sbs->findSkillByUserId($user_id);
                $educations = $eds->findEducationByUserId($user_id);
                
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
            else
            {
                return "Update job history unsuccessfully. Please try again";
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
     * validateJobHistoryFormForm method handles data validation in New Job History Form
     * @param Request $request
     */
    private function validateJobHistoryForm(Request $request)
    {
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
