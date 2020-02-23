<?php
/* CLC Project version 2.0
 * AdminController version 2.0
 * Adam Bender and Jim Nguyen
 * February 5, 2020
 * AdminController handles admin functionalities
 */
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\User;
use App\Services\Business\UserBusinessService;
class AdminController extends Controller
{
    
    // getUser shows all user in database
    public function getUsers(){
              
        $ubs = new UserBusinessService();
        $users= $ubs->findAllUser();
        // check user session for admin, if session is admin
        // calls showAllUser in Business Service
        //else return error message
        if($users != null){
            
            return view(('adminUsers'),compact(['users']));
        }else{
            return "User not found. Please try again";
        }
        
    } 
    
    // editUser method handles data from adminEditUserForm 
    // and pass it to findById method in UserBusinessService
    public function openUpdateUser(Request $request){
        
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
        
    }
    
    // updateUser method handles data from adminEditUserForm
    // and pass it to updateUser method in UserBusinessService
    public function updateUser(Request $request)
    {
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
        $result = $ubs->updateUser($updatedUser);
        
        // if success returns to homePage, else returns error message
        if($result)
        {
            $users= $ubs->findAllUser();
            return view(('adminUsers'),compact(['users']));
        }
        else
        {
            return "Update user unsuccessfully. Please try again";
        }
    }
    
    // processDeleteUser method handles data from adminEditUserForm
    // and pass it to processDeleteUser method in UserBusinessService
    public function processDeleteUser(Request $request)
    {
        //Get posted Form data
        $id = $request->input('id');
        
        
        $ubs = new UserBusinessService();
        
        // calls findById method in UserBusinessService and passes User Object
        $user = $ubs->findById($id);
        
        return view('adminProcessDelete')->with(compact('user'));
        
    }
    
    // deleteUser method handles data from adminUser
    // and pass it to deleteUser method in UserBusinessService
    public function deleteUser(Request $request)
    {
        //Get posted Form data
        $id = $request->input('id');
        
        //Save posted Form Data to User Object Model
        $theUser = new User($id, "", "", "", "", "", "", "", "", "");
        $ubs = new UserBusinessService();
        
        // calls deleteUser method in UserBusinessService and passes User Object
        $result = $ubs->deleteUser($theUser);
        
        
        //if success, return to homePage, else return error message
        if($result)
        {
            $users= $ubs->findAllUser();
            return view(('adminUsers'),compact(['users']));
        }
        else
        {
            return "Unable to delete user. Please try again!";
        }
    }
    
    // suspendUser method handles data from adminUser
    // and pass it to suspendUser method in UserBusinessService
    public function suspendUser(Request $request)
    {
        //Get posted Form data
        $id = $request->input('id');
        
        
        $ubs = new UserBusinessService();
        
        // calls suspendUser method in UserBusinessService and passes User Object
        // if success, return to adminUsers with data
        if($result = $ubs->findById($id)){
            $userSuspended = $ubs->suspendUser($result);
            $users= $ubs->findAllUser();
            return view(('adminUsers'),compact(['users']));
            
        }else
        {
            return "Unable to suspend user. Please try again!";
        }
    }
    
    // suspendUser method handles data from adminUser
    // and pass it to suspendUser method in UserBusinessService
    public function activateUser(Request $request)
    {
        //Get posted Form data
        $id = $request->input('id');
        
        $ubs = new UserBusinessService();
        
        // calls activateUser method in UserBusinessService and passes User Object
        // if success, return to adminUsers with data
        if($result = $ubs->findById($id)){
            $userSuspended = $ubs->activateUser($result);
            $users= $ubs->findAllUser();
            return view(('adminUsers'),compact(['users']));
            
        }else
        {
            return "Unable to activate user. Please try again!";
        }
    }
    
    // findByFirstName method handles data from adminUser
    // and pass it to findByFirstName method in UserBusinessService
    public function findByFirstName(Request $request)
    {
        //validate form
        $this->validateFirstNameSearchForm($request);
        
        //Get posted Form data
        $firstname = $request->input('firstname');
        
        //Save posted Form Data to User Object Model
        $theUser = new User("", "", "", $firstname, "", "", "", "", "","");
        $ubs = new UserBusinessService();
        
        // calls findByFirstName method in UserBusinessService and passes User Object
        // if success, return to adminUsers with data, else return error message
        if($users = $ubs->findByFirstName($theUser)){
        
            return view(('adminUsers'),compact(['users']));       
        }else{
            return "User not found. Please try again";
        }
    }
    
    // findByLastName method handles data from adminUser
    // and pass it to findByLastName method in UserBusinessService
    public function findByLastName(Request $request)
    {
        //validate form
        $this->validateLastNameSearchForm($request);
        
        //Get posted Form data
        $lastname = $request->input('lastname');
        
        //Save posted Form Data to User Object Model
        $theUser = new User("", "", "", "", $lastname, "", "", "", "", "");
        $ubs = new UserBusinessService();
        
        // calls findByLastName method in UserBusinessService and passes User Object
        // if success, return to adminUsers with data, else return error message
        if($users = $ubs->findByLastName($theUser)){
        
            return view(('adminUsers'),compact(['users']));
        }else{
            return "User not found. Please try again";
        }
    }
    
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
    
    private function validateLastNameSearchForm(Request $request)
    {
        $rules = ['lastname'=> 'Required|max:256'];
        
        // Run Data Validation Rules
        $this->validate($request, $rules);
    }
}

