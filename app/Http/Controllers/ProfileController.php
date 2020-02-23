<?php
/* CLC Project version 2.0
 * ProfileController version 1.0
 * Adam Bender and Jim Nguyen
 * February 5, 2020
 * ProfileController handles user profile action
 */
namespace App\Http\Controllers;

use App\Model\User;
use App\Services\Business\UserBusinessService;
use App\Services\Business\JobBusinessService;
use Illuminate\Http\Request;


class ProfileController extends Controller
{
    /* openProfile method handle data from the home page
     and pass to UserBusinessService and return to
     the user profile page*/
    public function openProfile(Request $request)
    {
        $id = $request->input('id');
        
        // 
        $ubs = new UserBusinessService();
        
        $user = $ubs->findById($id);
        
        
        return view('userProfilePage')->with(compact('user'));
    }
    
    /* openProfile method handle data from the home page
     and pass to UserBusinessService and return to
     the user profile page*/
    public function openUpdateProfile(Request $request)
    {
        $id = $request->input('id');
        
        //
        $ubs = new UserBusinessService();
        
        $users = $ubs->findById($id);
        
        
        return view('userProfile')->with(compact('users'));
    }
    
    /* updateProfile method handles user profile update
    request using BusinessService*/
    public function updateProfile(Request $request)
    {
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
        
        $updatedUser = new User($id, $username, $password, $firstname, $lastname, $email, $phonenumber, $city, $role, $status);
        
        //calls updateUser in UserBusinessService and pass $updateUser
        $ubs = new UserBusinessService();
        $result = $ubs->updateUser($updatedUser);
        
        //if result exisits return to Home Page else return error message
        if($result)
        {
            $user = $ubs->findById($id);

            return view('userProfilePage')->with(compact('user'));
        }
        else
        {
            return "Update profile unsuccessfully. Please try again.";
        }
    }
    
    public function getUserProfile(Request $request){
        
    }
}