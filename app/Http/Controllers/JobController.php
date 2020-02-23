<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Job;
use App\Services\Business\JobBusinessService;

class JobController extends Controller
{
    // add a job
    public function createJob(Request $request){
        
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
        
        // calls deleteUser method in UserBusinessService and passes User Object
        $result = $jbs->deleteJob($theJob);
        
        
        //if success, return to homePage, else return error message
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
        
        //Save posted Form Data to User Object Model
        
        $jbs = new JobBusinessService();
        
        // calls findById method in UserBusinessService and passes User Object
        if($job = $jbs->findById($id)){
            
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
        
        //Save posted Form Data to User Object Model
        $updatedJob = new Job($id, $jobtitle, $category, $description, $requirements, $company, $location, $salary);
        
        // calls findById method in UserBusinessService and passes User Object
        $jbs = new JobBusinessService();
        $result = $jbs->updateJob($updatedJob);
        
        // if success returns to homePage, else returns error message
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
    //find all job
    // getUser shows all user in database
    public function findAllJobs(){
        
        $jbs = new JobBusinessService();
        $jobs = $jbs->findAllJobs();
        // check user session for admin, if session is admin
        // calls findAllJobs in Business Service
        //else return error message
            
        return view(('adminJobs'),compact(['jobs']));
        
    } 
    
    public function findAllFeaturedJobs(){
        
        $jbs = new JobBusinessService();
        $jobs = $jbs->findAllJobs();
        // calls findAllJobs in Business Service
        
        return view(('homePage'),compact(['jobs']));
        
    } 
    
    
    // find job by title
    
    // find job by category
    
    // find job by location
}
