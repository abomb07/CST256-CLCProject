<?php
/*
 * CLC Project version 5.0
 * JobController version 5.0
 * Adam Bender and Jim Nguyen
 * March 15, 2020
 * Job Controller handles job functionalities
 */
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use App\Model\Job;
use App\Services\Business\JobBusinessService;
use App\Services\Business\SkillBusinessService;
use Exception;
use Validator;
use App\Services\Business\EducationBusinessService;
use App\Services\Business\JobHistoryBusinessService;

class JobController extends Controller
{
    /**
     * createJob method handles data from New Job Form
     * @param Request $request
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function createJob(Request $request)
    {
        try{
            // validate form by calling validateJobForm
            $this->validateJobForm($request);
            //Get posted form data
            $jobtitle = $request->input('jobtitle');
            $category = $request->input('category');
            $description = $request->input('description');
            $requirements = $request->input('requirements');
            $company = $request->input('company');
            $location = $request->input('location');
            $salary = $request->input('salary');
            
            $job = new Job(0, $jobtitle, $category, $description, $requirements, $company, $location, $salary);
            $service = new JobBusinessService();
            
            if($result = $service->addJob($job))
            {
                $jobs = $service->findAllJobs();
                return view(('adminJobs'),compact(['jobs']));
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
     * processDeleteJob method handles data from editJobForm 
     * and pass it to processDeleteJob method in JobBusinessService
     * @param Request $request
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function processDeleteJob(Request $request)
    {
        //Get posted Form data
        $id = $request->input('id');
        
        $jbs = new JobBusinessService();
        
        // calls findById method in UserBusinessService and passes User Object
        $job = $jbs->findById($id);
        
        return view('adminProcessJobDelete')->with(compact('job'));
    }
    
    /**
     * deleteJob method handles data from adminUser
     * and pass it to deleteJob method in JobBusinessService
     * @param Request $request
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory|string
     */
    public function deleteJob(Request $request)
    {
        try
        {
            //Get posted Form data
            $id = $request->input('id');
            
            //Save posted Form Data to User Object Model
            $theJob = new Job($id, "", "", "", "", "", "", "");
            $jbs = new JobBusinessService();
            
            // calls deleteUser method in JobBusinessService and passes Job Object
            $result = $jbs->deleteJob($theJob);
            
            //if success, return to adminJobs, else return error message
            if($result)
            {
                $jobs = $jbs->findAllJobs();
                return view(('adminJobs'),compact(['jobs']));
            }
            else
            {
                return "Unable to delete job. Please try again!";
            }
        
        }catch(Exception $e2){
            Log::info("Exception ". array("message" => $e2->getMessage()));
            //Display Global Namespace Handler Page
            return view('SystemException');
        }
    }
    
    /**
     * openUpdateJob method handles data from editJobForm
     * and pass it to findById method in JobBusinessService
     * @param Request $request
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory|string
     */
    public function openUpdateJob(Request $request)
    {
        try
        {
            //Get posted Form data
            $id = $request->input('id');
            
            //Save posted Form Data to Job Object Model
            
            $jbs = new JobBusinessService();
            
            // calls findById method in JobBusinessService and passes Job Object
            if($job = $jbs->findById($id))
            {
                //if success, return to adminEditJobForm, else return error message
                return view('adminEditJobForm')->with(compact('job'));
            }else{
                return "Job not found. Please try again";
            }
        
        }catch(Exception $e2){
            Log::info("Exception ". array("message" => $e2->getMessage()));
            //Display Global Namespace Handler Page
            return view('SystemException');
        }
    }
    
    /**
     * updateJob method handles data from editJobForm
     * and pass it to updateJob method in JobBusinessService
     * @param Request $request
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory|string
     */
    public function updateJob(Request $request)
    {
        try{
            //Get posted form data
            $id = $request->input('id');
            $jobtitle = $request->input('jobtitle');
            $category = $request->input('category');
            $description = $request->input('description');
            $requirements = $request->input('requirements');
            $company = $request->input('company');
            $location = $request->input('location');
            $salary = $request->input('salary');
            
            //Make validator rules
            $validator = Validator::make($request->all(), ['id' => 'Required',
                'jobtitle'=> 'Required|max:256',
                'category' => 'Required|max:256',
                'description' => 'Required|',
                'requirements' => 'Required|',
                'company' => 'Required|max:256',
                'location' => 'Required|max:256',
                'salary' => 'Required'
            ]);
            
            //if there is a validation error, reroute to form with errors and model
            if($validator->fails())
            {
                $errors = $validator->errors();
                
                $jbs = new JobBusinessService();
                
                // calls findById method in JobBusinessService and passes Job Object
                $job = $jbs->findById($id);
                
                //return to view with model and errors
                return view('adminEditJobForm')->with(compact('job', 'errors'));
            }
            
            //Save posted Form Data to Job Object Model
            $updatedJob = new Job($id, $jobtitle, $category, $description, $requirements, $company, $location, $salary);
            
            // calls findById method in JobBusinessService and passes Job object
            $jbs = new JobBusinessService();
            $result = $jbs->editJob($updatedJob);
            
            // if success returns to adminJobs, else returns error message
            if($result)
            {
                $jobs = $jbs->findAllJobs();
                return view(('adminJobs'),compact(['jobs']));
            }
            else
            {
                return "Update job unsuccessfully. Please try again";
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
     * findAllJobs method shows all jobs in database 
     * and return in the adminJobs
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function findAllJobs()
    {
        try{
            //
            $jbs = new JobBusinessService();
            $jobs = $jbs->findAllJobs();
            
            // calls findAllJobs in Business Service
            //else return error message
                
            return view(('adminJobs'),compact(['jobs']));
        
        }catch(Exception $e2){
            Log::info("Exception ". array("message" => $e2->getMessage()));
            //Display Global Namespace Handler Page
            return view('SystemException');
        }
    } 
    
    /**
     * findAllFeaturedJobs method shows all job in database
     * and return in the homePage
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function findAllFeaturedJobs()
    {
        try{
            // calls findAllJobs in Business Service
            $jbs = new JobBusinessService();
            $jobs = $jbs->findAllJobs();
            
            return view(('homePage'),compact(['jobs']));
        
        }catch(Exception $e2){
            Log::info("Exception ". array("message" => $e2->getMessage()));
            //Display Global Namespace Handler Page
            return view('SystemException');
        }
    } 
    
    /**
     * validateJobForm method handles data validation in New Job Form
     * @param Request $request
     */
    private function validateJobForm(Request $request){
        
        // data validation rules for Register Form
        $rules = ['jobtitle'=> 'Required|max:256',
            'category' => 'Required|max:256',
            'description' => 'Required|',
            'requirements' => 'Required|',
            'company' => 'Required|max:256',
            'location' => 'Required|max:256',
            'salary' => 'Required',
        ];
        
        // Run Data Validation Rules
        $this->validate($request, $rules);
    }
    
    
    /**
     * Returns jobs by the inputed title
     * @param Request $request
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function findByTitle(Request $request)
    {
        try{
            //Get posted form data
            $title = $request->input('jobtitle');
            $theJob = new Job("", $title, "", "", "", "", "", "");
            
            //findByJobTitle in the JobBusinessService
            $jbs = new JobBusinessService();
            $jobs = $jbs->findByJobTitle($theJob);
            
            //return all jobs if input is null
            if($title == null)
            {
                // call findAllJobs in JobBusinessService class
                $jobs = $jbs->findAllJobs();
            }
            
            //return jobSearchResults page with found jobs
            return view(('jobSearchResults'),compact(['jobs']));
        
        }catch(Exception $e2){
            Log::info("Exception ". array("message" => $e2->getMessage()));
            //Display Global Namespace Handler Page
            return view('SystemException');
        }
    } 
    
    /**
     * Returns jobs by the inputed description
     * @param Request $request
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function findByDescription(Request $request)
    {
        try{
            //Get posted form data
            $description = $request->input('jobdescription');
            $theJob = new Job("", "", "", $description, "", "", "", "");
            
            $jbs = new JobBusinessService();
            $jobs = $jbs->findByJobDescription($theJob);
            
            //return all jobs if input is null
            if($description == null)
            {
                // call findAllJobs in JobBusinessService class
                $jobs = $jbs->findAllJobs();
            }
            
            // returns to jobSearchResults with found jobs
            return view(('jobSearchResults'),compact(['jobs']));
            
        }catch(Exception $e2){
            Log::info("Exception ". array("message" => $e2->getMessage()));
            //Display Global Namespace Handler Page
            return view('SystemException');
        }
    } 
    
    /**
     * Returns jobs by the inputed location
     * @param Request $request
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function findByLocation(Request $request)
    {
        try{
            //Get posted form data
            $location = $request->input('joblocation');
            $theJob = new Job("", "", "", "", "", "", $location, "");
            
            $jbs = new JobBusinessService();
            // call 
            $jobs = $jbs->findByJobLocation($theJob);
            
            // calls findAlljobs in Job Business Services to return jobs
            //return all jobs if input is null
            if($location == null)
            {
                // call findAllJobs in JobBusinessService class
                $jobs = $jbs->findAllJobs();
            }
            
            // returns to jobSearchResults with found jobs
            return view(('jobSearchResults'),compact(['jobs']));
            
        }catch(Exception $e2){
            Log::info("Exception ". array("message" => $e2->getMessage()));
            //Display Global Namespace Handler Page
            return view('SystemException');
        }
    } 
    
    /**
     * Show details of selected job
     * @param Request $request
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function showDetails(Request $request)
    {
        try{
            //id of job selected
            $id = $request->input('id');
            
            //calls findById in the JobBusinessService
            $jbs = new JobBusinessService();
            $job = $jbs->findById($id);
            
            //return to jobDetails with job information
            return view('jobDetails')->with(compact('job'));
            
        }catch(Exception $e2){
            Log::info("Exception ". array("message" => $e2->getMessage()));
            //Display Global Namespace Handler Page
            return view('SystemException');
        }
    } 
    
    /**
     * Simple application success page returned when user applies to job
     * @param Request $request
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function applyToJob(Request $request)
    {
        try{
            //Get posted form data
            $title = $request->input('jobtitle');
            $company = $request->input('jobcompany');
            
            // returns to jobApplySucess page
            return view(('jobApplySuccess'),compact(['title'], ['company']));
            
        }catch(Exception $e2){
            Log::info("Exception ". array("message" => $e2->getMessage()));
            //Display Global Namespace Handler Page
            return view('SystemException');
        }
    }
    
    public function jobMatch(Request $request)
    {
         try{
             //Get posted form data
            $user_id = $request->input('id');
            
            // Call neccesary Business Classes
            $sbs = new SkillBusinessService();
            $ebs = new EducationBusinessService();
            $jhbs = new JobHistoryBusinessService();
            $jbs = new JobBusinessService();
            
            // find skills education and job history with user id
            $skills = $sbs->findSkillByUserId($user_id);
            $education = $ebs->findEducationByUserId($user_id);
            $jobhistory = $jhbs->findJobHistoryByUserId($user_id);
            
            $jobs = array();
            // if statements call jobMatch when 
            // find user's skills, education, and job history
            if($skills || $education || $jobhistory)
            {               
                // call jobMatch in Job Business Service
                $jobs = $jbs->jobMatch($skills, $education, $jobhistory);
            }
            else {
                // responses with errors when $skills & $education & $jobhistory is empty
                // if erros return errorPage with message
                $error = "Please fill out your portfolio";
                return view(('errorPage'),compact(['error']));
            }
            
            // returns to jobSearchResults with found jobs
            return view(('jobSearchResults'),compact(['jobs']));
            
         }catch(Exception $e2){
             Log::info("Exception ". array("message" => $e2->getMessage()));
             //Display Global Namespace Handler Page
             return view('SystemException');
         }
    }
    
    /**
     * findBySkills method takes skills as parameter
     * and find all jobs that matched user skills
     * @param Request $request
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function findBySkills(Request $request)
    {
        try{
            //Get posted form data
            $user_id = $request->input('id');
            
            // Call neccesary Business Classes
            $sbs = new SkillBusinessService();
            $jbs = new JobBusinessService();
            
            // call findSkillByUserId in SkillBusinessService
            $skills = $sbs->findSkillByUserId($user_id);
            
            // if statement loops through found skills
            if($skills){
               
                for($i = 0; $i < count($skills); $i++)
                {
                    // find jobs with matched Skills
                    $jobs = $jbs->findBySkills($skills[$i]['SKILL']);
                }
            }

            // returns to jobSearchResults with found jobs
            return view(('jobSearchResults'),compact(['jobs']));
            
        }catch(Exception $e2){
            Log::info("Exception ". array("message" => $e2->getMessage()));
            //Display Global Namespace Handler Page
            return view('SystemException');
        }
    }
    
    /**
     * findByEducation method takes education as parameter
     * and find all jobs that matched user education
     * @param Request $request
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function findByEducation(Request $request)
    {
        try{
            //Get posted form data
            $user_id = $request->input('id');
            
            // Call neccesary Business Classes
            $ebs = new EducationBusinessService();
            $jbs = new JobBusinessService();
            
            // call findEducationByUserId with user id in Education Business Service
            $education = $ebs->findEducationByUserId($user_id);
            
            // if statement loops through found education
            if($education){
                
                for($i = 0; $i < count($education); $i++)
                {
                    // find jobs with matched education
                    $jobs = $jbs->findByEducation($education[$i]['FIELD']);
                }
            }
            
            // returns to jobSearchResults with found jobs
            return view(('jobSearchResults'),compact(['jobs']));
            
        }catch(Exception $e2){
            Log::info("Exception ". array("message" => $e2->getMessage()));
            //Display Global Namespace Handler Page
            return view('SystemException');
        }
    }
    
    /**
     * findByJobHistory method takes education as parameter
     * and find all jobs that matched user education
     * @param Request $request
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function findByJobHistory(Request $request)
    {
        try{
            //Get posted form data
            $user_id = $request->input('id');
            
            $jhbs = new JobHistoryBusinessService();
            $jbs = new JobBusinessService();
            
            // call findJobHistoryByUserId with user id
            $jobhistory = $jhbs->findJobHistoryByUserId($user_id);
            
            // if statement loops through found job history
            if($jobhistory){
                
                for($i = 0; $i < count($jobhistory); $i++)
                {
                    // find jobs with matched job history
                    $jobs = $jbs->findByJobHistory($jobhistory[$i]['TITLE']);
                }
            }
            
            // returns to jobSearchResults with found jobs
            return view(('jobSearchResults'),compact(['jobs']));
            
        }catch(Exception $e2){
            Log::info("Exception ". array("message" => $e2->getMessage()));
            //Display Global Namespace Handler Page
            return view('SystemException');
        }
    }
}
