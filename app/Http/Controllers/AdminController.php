<?php
/*
 * CLC Project version 4.0
 * AdminController version 4.0
 * Adam Bender and Jim Nguyen
 * March 8, 2020
 * Admin Controller handles admin functionalities
 */
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Exception;
use App\Model\User;
use App\Services\Business\UserBusinessService;
use App\Services\Business\GroupBusinessService;
class AdminController extends Controller
{
    
    /**
     * getUsers method handles data from the database
     * and pass it to findAllUser method in the UserBusiness Service 
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory|string
     */
    public function getUsers()
    {
        try{
            $ubs = new UserBusinessService();
            $users = $ubs->findAllUsers();
            // check user session for admin, if session is admin
            // calls showAllUser in Business Service
            //else return error message
            if($users != null){
                
                return view(('adminUsers'),compact(['users']));
            }else{
                return "User not found. Please try again";
            }
        }catch(Exception $e2){
            Log::info("Exception ". array("message" => $e2->getMessage()));
            //Display Global Namespace Handler Page
            return view('SystemException');
        }
    } 
    
    /**
     * openUpdateUser method handles data from adminUsers 
     * and pass it to findById method in UserBusinessService
     * @param Request $request
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory|string
     */
    public function openUpdateUser(Request $request)
    {
        try{
            //Get posted Form data
            $id = $request->input('id');
            
            //Save posted Form Data to User Object Model
            
            $ubs = new UserBusinessService();
            
            // calls findById method in UserBusinessService and passes User Object
            if($user = $ubs->findById($id)){
                
                return view('adminEditUserForm')->with(compact('user'));
            }else{
                return "User not found. Please try again";
            }
        }catch(Exception $e2){
            Log::info("Exception ". array("message" => $e2->getMessage()));
            //Display Global Namespace Handler Page
            return view('SystemException');
        }
    }
    
    /**
     * updateUser method handles data from adminEditUserForm 
     * and pass it to updateUser method in UserBusinessService
     * @param Request $request
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory|string
     */
    public function updateUser(Request $request)
    {
        try{
            //Get posted Form data
            $id = $request->input('id');
            $username = $request->input('username');
            $password = $request->input('password');
            $firstname = $request->input('firstname');
            $lastname = $request->input('lastname');
            $email = $request->input('email');
            $phonenumber = $request->input('phonenumber');
            $city = $request->input('city');
            $role = $request->input('role');
            $status = $request->input('status');
            
            //Save posted Form Data to User Object Model
            $updatedUser = new User($id, $username, $password, $firstname, $lastname, $email, $phonenumber, $city, $role, $status);
            
            // calls findById method in UserBusinessService and passes User Object
            $ubs = new UserBusinessService();
            $result = $ubs->editUSer($updatedUser);
            
            // if success returns to homePage, else returns error message
            if($result)
            {
                $users= $ubs->findAllUsers();
                return view(('adminUsers'),compact(['users']));
            }
            else
            {
                return "Update user unsuccessfully. Please try again";
            }
    
        }catch(Exception $e2){
            Log::info("Exception ". array("message" => $e2->getMessage()));
            //Display Global Namespace Handler Page
            return view('SystemException');
        }
    }
    
    /**
     * processDeleteUser method handles data from adminUsers
     * and pass it to findById method in UserBusinessService
     * @param Request $request
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function processDeleteUser(Request $request)
    {
        try{
            //Get posted Form data
            $id = $request->input('id');
            
            $ubs = new UserBusinessService();
            
            // calls findById method in UserBusinessService and passes User Object
            $user = $ubs->findById($id);
            
            return view('adminProcessDelete')->with(compact('user'));
        }catch(Exception $e2){
            Log::info("Exception ". array("message" => $e2->getMessage()));
            //Display Global Namespace Handler Page
            return view('SystemException');
        }
    }
    
    /**
     * deleteUser method handles data from adminDeleteUserForm
     * and pass it to deleteUser method in UserBusinessService
     * @param Request $request
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory|string
     */
    public function deleteUser(Request $request)
    {
        //try{
            //Get posted Form data
            $id = $request->input('id');
            
            //Save posted Form Data to User Object Model
            $theUser = new User($id, "", "", "", "", "", "", "", "", "");
            $ubs = new UserBusinessService();
            $gbs = new GroupBusinessService();
            
            //delete user from all the groups they are in
            $result1 = $gbs->leaveAllGroups($id);
            // calls deleteUser method in UserBusinessService and passes User Object
            $result = $ubs->deleteUser($theUser);
            
            //if success, return to homePage, else return error message
            if($result && $result1)
            {
                $users = $ubs->findAllUsers();
                return view(('adminUsers'),compact(['users']));
            }
            else
            {
                return "Unable to delete user. Please try again!";
            }
        /* }catch(Exception $e2){
            Log::info("Exception ". array("message" => $e2->getMessage()));
            //Display Global Namespace Handler Page
            return view('SystemException');
        } */
    }
    
    /**
     * suspendUser method handles data from adminUsers
     * and pass it to suspendUser method in UserBusinessService
     * @param Request $request
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory|string
     */
    public function suspendUser(Request $request)
    {
        try{
            //Get posted Form data
            $id = $request->input('id');
            
            $ubs = new UserBusinessService();
            
            // calls suspendUser method in UserBusinessService and passes User Object
            // if success, return to adminUsers with data
            if($result = $ubs->findById($id))
            {
                $userSuspended = $ubs->suspendUser($result);
                $users= $ubs->findAllUsers();
                return view(('adminUsers'),compact(['users']));
                
            }else
            {
                return "Unable to suspend user. Please try again!";
            }
        }catch(Exception $e2){
            //Display Global Namespace Handler Page
            return view('SystemException');
        }
    }
    
    /**
     * activateUser method handles data from adminUsers
     * and pass it to activateUser method in UserBusinessService
     * @param Request $request
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory|string
     */
    public function activateUser(Request $request)
    {
        try{
            //Get posted Form data
            $id = $request->input('id');
            
            $ubs = new UserBusinessService();
            
            // calls activateUser method in UserBusinessService and passes User Object
            // if success, return to adminUsers with data
            if($result = $ubs->findById($id)){
                $userSuspended = $ubs->activateUser($result);
                $users= $ubs->findAllUsers();
                return view(('adminUsers'),compact(['users']));
                
            }else
            {
                return "Unable to activate user. Please try again!";
            }
        }catch(Exception $e2){
            Log::info("Exception ". array("message" => $e2->getMessage()));
            //Display Global Namespace Handler Page
            return view('SystemException');
        }
    }
    
    /**
     * findByFirstName method handles data from adminSearchForm
     * and pass it to findByFirstName method in UserBusinessService
     * @param Request $request
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory|string
     */
    public function findByFirstName(Request $request)
    {
        try{
            //validate form
            $this->validateFirstNameSearchForm($request);
            
            //Get posted Form data
            $firstname = $request->input('firstname');
            
            //Save posted Form Data to User Object Model
            $theUser = new User("", "", "", $firstname, "", "", "", "", "","");
            $ubs = new UserBusinessService();
            
            // calls findByFirstName method in UserBusinessService and passes User Object
            // if success, return to adminUsers with data, else return error message
            if($users = $ubs->findUserByFirstName($theUser)){
            
                return view(('adminUsers'),compact(['users']));       
            }else{
                return "User not found. Please try again";
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
     * findByLastName method handles data from adminSearchForm 
     * and pass it to findByLastName method in UserBusinessService
     * @param Request $request
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory|string
     */
    public function findByLastName(Request $request)
    {
        try{
            //validate form
            $this->validateLastNameSearchForm($request);
            
            //Get posted Form data
            $lastname = $request->input('lastname');
            
            //Save posted Form Data to User Object Model
            $theUser = new User("", "", "", "", $lastname, "", "", "", "", "");
            $ubs = new UserBusinessService();
            
            // calls findByLastName method in UserBusinessService and passes User Object
            // if success, return to adminUsers with data, else return error message
            if($users = $ubs->findUserByLastName($theUser)){
            
                return view(('adminUsers'),compact(['users']));
            }else{
                return "User not found. Please try again";
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
     * validateFirstNameSearchForm method handles data validation in Admin Search Form
     * @param Request $request
     */
    private function validateFirstNameSearchForm(Request $request)
    {
        //BEST PRATICE: centralize your rule so you have a consistent architecture
        //and even resuse your rules
        //BAD PRATICES: not using a defined data validation Framework, putting rules
        //all over your coe, doing only on CLient side and database
        //SEt up data validation for login form
        $rules = ['firstname'=> 'Required|max:256'];
        
        // Run Data Validation Rules
        $this->validate($request, $rules);
    }
    
    /**
     * validateLastNameSearchForm method handles data validation in Admin Search Form
     * @param Request $request
     */
    private function validateLastNameSearchForm(Request $request)
    {
        $rules = ['lastname'=> 'Required|max:256'];
        
        // Run Data Validation Rules
        $this->validate($request, $rules);
    }
}

