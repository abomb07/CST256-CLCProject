<?php
/*
 * CLC Project version 6.0
 * EducationController version 6.0
 * Adam Bender and Jim Nguyen
 * April 17, 2020
 * Education Controller handles education functionalities
 */
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Model\Education;
use App\Services\Business\SkillBusinessService;
use App\Services\Business\EducationBusinessService;
use App\Services\Business\JobHistoryBusinessService;
use App\Services\Business\GroupBusinessService;
use Exception;
use Validator;
use App\Services\Utility\ILoggerService;

class EducationController extends Controller
{
    protected $logger;
    
    public function __construct(ILoggerService $logger)
    {
        $this->logger = $logger;
    }
    
    /**
     * createEducation method handles data from New Education Form
     * @param Request $request
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function createEducation(Request $request)
    {
        try
        {
            //validate form by calling validateCreateForm
            $this->validateCreateForm($request);
            
            //Get posted form data
            $school = $request->input('school');
            $degree = $request->input('degree');
            $field = $request->input('field');
            $graduationyear = $request->input('graduationyear');
            $user_id = $request->input('user_id');
            
            // Save posted data to Education object model
            $education = new Education(0, $school, $degree, $field, $graduationyear, $user_id);
            
            $jhbs = new JobHistoryBusinessService();
            $sbs = new SkillBusinessService();
            $eds = new EducationBusinessService();
            $gbs = new GroupBusinessService();
           
            // if addEducation sucesses call findGroupsByUserId,
            // findJobHistoryByUserId, findSkillByUserId and findEducationByUserId
            // to return user portfolio with jobhistorys, skills, educations, groups objects
            if($result = $eds->addEducation($education))
            {
                $groups = $gbs->findGroupsByUserId($user_id);
                $jobhistorys = $jhbs->findJobHistoryByUserId($user_id);
                $skills = $sbs->findSkillByUserId($user_id);
                $educations = $eds->findEducationByUserId($user_id);
                
                //pass groups user is apart of to portfolio
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
                
                // return to userPortfolio Form with jobhistorys, skills, educations, groups objects
                return view(('userPortfolio'),compact(['jobhistorys'],['skills'], ['educations'], ['groupNames']));
            }
        }catch(ValidationException $e1){
            throw ($e1);
        }catch(Exception $e2){
            $this->logger->error("Exception ". array("message" => $e2->getMessage()));
            //Display Global Namespace Handler Page
            return view('SystemException');
        }
    }
    
    /**
     * processDelete method handles data from userPortfolio
     * and pass it to findById method in EducationBusinessService
     * @param Request $request
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function processDelete(Request $request)
    {
        try
        {
            //Get posted Form data
            $id = $request->input('id');
            
            $ebs = new EducationBusinessService();
            
            // calls findById method in UserBusinessService and passes User Object
            $education = $ebs->findById($id);
            
            // return to userPortfolio Form with educations objects
            return view('userPortfolioDeleteEducation')->with(compact('education'));
        
        }catch(Exception $e2){
            $this->logger->error("Exception ". array("message" => $e2->getMessage()));
            //Display Global Namespace Handler Page
            return view('SystemException');
        }
        
    }
    
    /**
     * deleteEducation method handles data from userPortfolioDeleteEducation
     * and pass it to deleteEducation method in EducationBusinessService
     * @param Request $request
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function deleteEducation(Request $request)
    {
        try{
            //Get posted Form data
            $id = $request->input('id');
            $user_id = $request->input('user_id');
            
            //Save posted Form Data to Education Object Model
            $education = new Education($id, "", "", "", "", "");
            $sbs = new SkillBusinessService();
            $jhbs = new JobHistoryBusinessService();
            $eds = new EducationBusinessService();
            $gbs = new GroupBusinessService();
            
            
            // calls deleteUser method in EducationBusinessService and passes Education Object
            $result = $eds->deleteEducation($education);
            
            //if success, return to homePage, else return error message
            if($result)
            {
                $groups = $gbs->findGroupsByUserId($user_id);
                $jobhistorys = $jhbs->findJobHistoryByUserId($user_id);
                $skills = $sbs->findSkillByUserId($user_id);
                $educations = $eds->findEducationByUserId($user_id);
                
                //pass groups user is apart of to portfolio
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
            $this->logger->error("Exception ". array("message" => $e2->getMessage()));
            //Display Global Namespace Handler Page
            return view('SystemException');
        }
    }
    
    /**
     * openUpdateEducation method handles data from portfolio
     * and pass it to findById method in EducationBusinessService
     * @param Request $request
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory|string
     */
    public function openUpdateEducation(Request $request)
    {
        try{
            //Get posted Form data
            $id = $request->input('id');
            
            //Save posted Form Data to User Object Model            
            $ebs = new EducationBusinessService();
            
            // calls findById method in UserBusinessService and passes User Object
            if($education = $ebs->findById($id)){
                
                return view('userPortfolioEditEducation')->with(compact('education'));
            }else{
                $error = "Education not found. Please try again";
                return view(('errorPage'),compact(['error']));
            }
        
        }catch(Exception $e2){
            $this->logger->error("Exception ". array("message" => $e2->getMessage()));
            //Display Global Namespace Handler Page
            return view('SystemException');
        }
    }
    
    /**
     * updateEducation method handles data from editEducationForm
     * and pass it to updateEducation method in EducationBusinessService
     * @param Request $request
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function updateEducation(Request $request)
    {
        try
        {
            //Get posted form data
            $id = $request->input('id');
            $school = $request->input('school');
            $degree = $request->input('degree');
            $field = $request->input('field');
            $graduationyear = $request->input('graduationyear');
            $user_id = $request->input('user_id');
            
            //Make validator rules
            $validator = Validator::make($request->all(), ['id' => 'Required',
                'school'=> 'Required|max:256',
                'degree'=> 'Required|max:256',
                'field'=> 'Required|max:256',
                'graduationyear'=> 'Required|numeric|max:3000',
                'user_id' => 'Required'
            ]);
            
            //if there is a validation error, reroute to form with errors and model
            if($validator->fails())
            {
                $errors = $validator->errors();
                $ebs = new EducationBusinessService();
                
                // calls findById method in EducationBusinessService and passes Education Object
                $education = $ebs->findById($id);
                
                //return to view with model and errors
                return view('userPortfolioEditEducation')->with(compact('education', 'errors'));
            }
            
            //Save posted Form Data to Skill Object Model
            $updatedEducation = new Education($id, $school, $degree, $field, $graduationyear, $user_id);
            
            // calls update method in SkillBusinessService and passes Skill Object
            $jhbs = new JobHistoryBusinessService();
            $sbs = new SkillBusinessService();
            $eds = new EducationBusinessService();
            $gbs = new GroupBusinessService();
            
            
            $result = $eds->editEducation($updatedEducation);
            
            // if success returns to homePage, else returns error message
            if($result)
            {
                $groups = $gbs->findGroupsByUserId($user_id);
                $jobhistorys = $jhbs->findJobHistoryByUserId($user_id);
                $skills = $sbs->findSkillByUserId($user_id);
                $educations = $eds->findEducationByUserId($user_id);
                
                //if groups exist
                if($groups)
                {
                    // loop through groups and return array of groups 
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
            $this->logger->error("Exception ". array("message" => $e2->getMessage()));
            //Display Global Namespace Handler Page
            return view('SystemException');
        }
    }

    /**
     * validateCreateForm method handles data validation in New Education Form
     * @param Request $request
     */
    private function validateCreateForm(Request $request)
    {
        // data validation rules for New Education Form
        $rules = ['school'=> 'Required|max:256',
            'degree'=> 'Required|max:256',
            'field'=> 'Required|max:256',
            'graduationyear'=> 'Required|numeric|max:3000'
        ];
        
        // Run Data Validation Rules
        $this->validate($request, $rules);
    }
    
}
