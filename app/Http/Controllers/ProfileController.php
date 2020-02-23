<?php
/* CLC Project version 2.0
 * ProfileController version 1.0
 * Adam Bender and Jim Nguyen
 * February 23, 2020
 * ProfileController handles user profile action
 */
namespace App\Http\Controllers;

use App\Model\User;
use App\Services\Business\UserBusinessService;
use App\Services\Business\JobBusinessService;
use Illuminate\Http\Request;
use Validator;

class ProfileController extends Controller
{
    /* openProfile method handle data from the home page
     and pass to UserBusinessService and return to
     the user profile page*/
    public function openProfile(Request $request)
    {
        $id = $request->input('id');
        
        $ubs = new UserBusinessService();
        
        $user = $ubs->findById($id);
        
        // return user object to userProfilePage view
        return view('userProfilePage')->with(compact('user'));
    }
    
    /* openUpdateProfile method handle data from the home page
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
    
    //redirectProfile method handles data from data validation
    //and passes it back to the edit form
    public function redirectProfile($id, $errors)
    {
        
        $ubs = new UserBusinessService();
        
        // calls findById method in UserBusinessService and passes User Object
        $users = $ubs->findById($id);
        
        //return to view with model and errors
        return view('userProfile')->with(compact('users', 'errors'));
    }
    
    /* updateProfile method handles user profile update
    request using UserBusinessService*/
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
        
        //Make validator rules
        $validator = Validator::make($request->all(), ['id' => 'Required',
            'username'=> 'Required|max:256',
            'password' => 'Required|max:256',
            'firstname' => 'Required|max:256',
            'lastname' => 'Required|max:256',
            'email' => 'Required|max:256',
            'phonenumber' => 'Required|numeric',
            'city' => 'Required|max:256',
            'role' => 'Required',
            'status' => 'Required'
        ]);
        
        //if there is a validation error, reroute to form with errors and model
        if($validator->fails())
        {
            $errors = $validator->errors();
            return $this->redirectProfile($id, $errors);
        }
        
        $updatedUser = new User($id, $username, $password, $firstname, $lastname, $email, $phonenumber, $city, $role, $status);
        
        //calls updateUser in UserBusinessService and pass $updateUser
        $ubs = new UserBusinessService();
        $result = $ubs->updateUser($updatedUser);
        
        //if result exists return to user profile Page else return error message
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
    
}