<?php
/* CLC Project version 2.0
 * AccountController version 2.0
 * Adam Bender and Jim Nguyen
 * February 5, 2020
 * AccountController handles login, register and logout action
 */
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Services\Business\UserBusinessService;
use App\Services\Business\JobBusinessService;
use App\Model\Credential;
use App\Model\User;
use App\Services\Business\JobHistoryBusinessService;
use App\Services\Business\SkillBusinessService;
use App\Services\Business\EducationBusinessService;

class AccountController extends Controller
{
    
    public function register(Request $request)
    {
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
            if($ubs->createUser($user))
            {
            return view('loginForm');
            }
        }else{
            return view('registerExisted');
        }
        
    }
    /* login method handle data from Login Form
     and pass to UserBusinessService */
    public function login(Request $request)
    {
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
        
        
    }
    
    public function findPortfolio(Request $request)
    {        
        $user_id = $request->input('user_id');
        
        $jhbs = new JobHistoryBusinessService();
        $sbs = new SkillBusinessService();
        $eds = new EducationBusinessService();
        
        $jobhistorys = $jhbs->findByUserId($user_id);
        $skills = $sbs->findByUserId($user_id);
        $educations = $eds->findByUserId($user_id);
              
        return view(('userPortfolio'),compact(['jobhistorys'],['skills'], ['educations']));

    }
    
    //Logout method handles logout action and flush all sessions, return to Home Page
    public function logout()
    {
        Session::flush();
        
        $jbs = new JobBusinessService();
        $jobs = $jbs->findAllJobs();
        // calls findAllJobs in Business Service
        
        return view(('homePage'),compact(['jobs']));
    }
    
    private function validateRegisterForm(Request $request){
        //BEST PRATICE: centralize your rule so you have a consistent architecture
        //and even resuse your rules
        //BAD PRATICES: not using a defined data validation Framework, putting rules
        //all over your coe, doing only on CLient side and database
        //SEt up data validation for login form
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
    
    private function validateLoginForm(Request $request){
        //BEST PRATICE: centralize your rule so you have a consistent architecture
        //and even resuse your rules
        //BAD PRATICES: not using a defined data validation Framework, putting rules
        //all over your coe, doing only on CLient side and database
        //SEt up data validation for login form
        $rules = ['username'=> 'Required|max:256',
            'password' => 'Required|max:256'
        ];
        
        // Run Data Validation Rules
        $this->validate($request, $rules);
    }
}