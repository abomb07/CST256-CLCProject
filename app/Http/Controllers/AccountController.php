<?php
/*
 * CLC Project version 4.0
 * Account Controller version 4.0
 * Adam Bender and Jim Nguyen
 * March 8, 2020
 * AccountController handles register, login and logout action
 */
namespace App\Http\Controllers;

use App\Model\User;
use App\Model\Credential;
use App\Services\Business\UserBusinessService;
use App\Services\Business\JobBusinessService;
use App\Services\Business\JobHistoryBusinessService;
use App\Services\Business\SkillBusinessService;
use App\Services\Business\EducationBusinessService;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;
use Exception;
use App\Services\Business\MemberBusinessService;
use App\Services\Business\GroupBusinessService;
class AccountController extends Controller
{
    
    /**
     * register method handles data from Register Form and passes to UserBusinessService
     * @param Request $request
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function register(Request $request)
    {
        try{
            $this->validateRegisterForm($request);
            
            //Get posted Form data
            $username = $request->input('username');
            $password = $request->input('password');
            $firstname = $request->input('firstname');
            $lastname = $request->input('lastname');
            $email = $request->input('email');
            $phonenumber = $request->input('phonenumber');
            $city = $request->input('city');
            $role = $request->input('role');
            $status= $request->input('status');
            
            //Save posted Form Data to User Object Model
            $user = new User(0, $username, $password, $firstname, $lastname, $email, $phonenumber, $city, $role, $status);
            $ubs = new UserBusinessService();
            
            if($ubs->checkUsername($user)){
                //Create user and return to loginForm view
                if($ubs->register($user))
                {
                return view('loginForm');
                }
            }else{
                return view('registerExisted');
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
     * login method handle data from Login Form and pass to UserBusinessService
     * @param Request $request
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function login(Request $request)
    {
        try{
            $this->validateLoginForm($request);
            
            //Get posted Form data
            $username = $request->input('username');
            $password = $request->input('password');
            
            //Save posted Form Data to Credential Object Model
            $credential = new Credential($username, $password);
            
            $ubs = new UserBusinessService();
            
            // findUser and checkStatus if user is suspended
            // if user status is suspended, return error message
            // if credential is incorrect, return to loginFailed
            // if success return to loginSuccess
            $user = $ubs->findUser($credential);
            if($user != null){
                
                if($ubs->checkStatus($user)){
                    Session::put('username', $user->getUsername());
                    Session::put('id', $user->getId());
                    Session::put('role', $user->getRole());
                    Session::put('principal', 'true');
                    return view('loginSuccess');
                }else{
                    return view('loginSuspended');
                }
            }else{
                return view('loginFailed');
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
     * findPortfolio method handle data from login
     * and passes id to JobHistoryBusinessService
     * EducationBusinessService and SkillBusinessService
     * @param Request $request
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function findPortfolio(Request $request)
    {      
        try{
            $user_id = $request->input('user_id');
            
            $jhbs = new JobHistoryBusinessService();
            $sbs = new SkillBusinessService();
            $eds = new EducationBusinessService();
            
            
            $jobhistorys = $jhbs->findJobHistoryByUserId($user_id);
            $skills = $sbs->findSkillByUserId($user_id);
            $educations = $eds->findEducationByUserId($user_id);
            $gbs = new GroupBusinessService();
            $groups = $gbs->findGroupsByUserId($user_id);
            
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
        }catch(Exception $e2){
            Log::info("Exception ". array("message" => $e2->getMessage()));
            //Display Global Namespace Handler Page
            return view('SystemException');
        }
    }
    
    /**
     * Logout method handles logout action and flush all sessions, return to Home Page
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function logout()
    {
        try{
            Session::flush();
            
            // calls findAllJobs in Business Service
            $jbs = new JobBusinessService();
            $jobs = $jbs->findAllJobs();
            
            // return to HomePage with Form with job object
            return view(('homePage'),compact(['jobs']));
        }catch(Exception $e2){
            Log::info("Exception ". array("message" => $e2->getMessage()));
            //Display Global Namespace Handler Page
            return view('SystemException');
        }
    }
    
    /**
     * validateLoginForm method handles data validation in login Form
     * @param Request $request
     */
    private function validateLoginForm(Request $request){
        
        // data validation rules for Register Form
        $rules = ['username'=> 'Required|max:256',
            'password' => 'Required|max:256'
        ];
        
        // Run Data Validation Rules
        $this->validate($request, $rules);
    }
    
    /**
     * validateRegisterForm method handles data validation in Register Form
     * @param Request $request
     */
    private function validateRegisterForm(Request $request){
        
        // data validation rules for Register Form
        $rules = ['username'=> 'Required|max:256',
            'password' => 'Required|max:256',
            'firstname' => 'Required|max:256',
            'lastname' => 'Required|max:256',
            'email' => 'Required|max:256',
            'phonenumber' => 'Required|numeric',
            'city' => 'Required|max:256',
            'role' => 'Required'
        ];
        
        // Run Data Validation Rules
        $this->validate($request, $rules);
    }
    
    
}