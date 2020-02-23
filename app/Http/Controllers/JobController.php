<?php
/*
 * CLC Project version 3.0
 * New Skill Form version 3.0
 * Adam Bender and Jim Nguyen
 * February 23, 2020
 * Job Controller handles job functionalities
 */
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Job;
use App\Services\Business\JobBusinessService;
use Validator;

class JobController extends Controller
{
    // createJob method handles data from New Job Form
    public function createJob(Request $request)
    {
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
        
        if($result = $service->createJob($job)){
            $jobs = $service->findAllJobs();
            return view(('adminJobs'),compact(['jobs']));
        }
    }
    // processDeleteJob method handles data from editJobForm
    // and pass it to processDeleteJob method in JobBusinessService
    public function processDeleteJob(Request $request)
    {
        //Get posted Form data
        $id = $request->input('id');
        
        
        $jbs = new JobBusinessService();
        
        // calls findById method in UserBusinessService and passes User Object
        $job = $jbs->findById($id);
        
        return view('adminProcessJobDelete')->with(compact('job'));
        
    }
    
    // deleteJob method handles data from adminUser
    // and pass it to deleteJob method in JobBusinessService
    public function deleteJob(Request $request)
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
    }
    
    // openUpdateJob method handles data from editJobForm
    // and pass it to findById method in JobBusinessService
    public function openUpdateJob(Request $request){
        
        //Get posted Form data
        $id = $request->input('id');
        
        //Save posted Form Data to Job Object Model
        
        $jbs = new JobBusinessService();
        
        // calls findById method in JobBusinessService and passes Job Object
        if($job = $jbs->findById($id)){
            
            //if success, return to adminEditJobForm, else return error message
            return view('adminEditJobForm')->with(compact('job'));
        }else{
            return "Job not found. Please try again";
        }
        
    }
    
    // updateJob method handles data from editJobForm
    // and pass it to updateJob method in JobBusinessService
    public function updateJob(Request $request)
    {
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
        $result = $jbs->updateJob($updatedJob);
        
        // if success returns to adminJobs, else returns error message
        if($result)
        {
            $jobs = $jbs->findAllJobs();
            return view(('adminJobs'),compact(['jobs']));
        }
        else
        {
            return "Update user unsuccessfully. Please try again";
        }
    }
    
    /*findAllJobs method shows all jobs in database 
     * and return in the adminJobs
    */
    public function findAllJobs(){
        
        $jbs = new JobBusinessService();
        $jobs = $jbs->findAllJobs();
        
        // calls findAllJobs in Business Service
        //else return error message
            
        return view(('adminJobs'),compact(['jobs']));
        
    } 
    
    /* findAllFeaturedJobs method shows all job in database
     * and return in the homePage
     */
    public function findAllFeaturedJobs(){
        
        // calls findAllJobs in Business Service
        $jbs = new JobBusinessService();
        $jobs = $jbs->findAllJobs();
        
        
        return view(('homePage'),compact(['jobs']));
        
    } 
    
    /* validateJobForm method handles data validation in New Job Form
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
    
    
    /* find job by title
     * ==== future developement == 
    */
    
    /* find job by category
     * ==== future developement ==
     */
    
    /* find job by location
     * ==== future developement ==
     */
}
