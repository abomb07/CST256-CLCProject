<?php
/* CLC Project version 5.0
 * ProfileController version 5.0
 * Adam Bender and Jim Nguyen
 * March 15, 2020
 * ProfileController handles user profile action
 */
namespace App\Http\Controllers;

use App\Model\User;
use App\Services\Business\UserBusinessService;
use App\Services\Business\JobBusinessService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Exception;
use Validator;

class ProfileController extends Controller
{
    /**
     * openProfile method handle data from the home page
     and pass to UserBusinessService and return to
     the user profile page
     * @param Request $request
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function openProfile(Request $request)
    {
        try{
            $id = $request->input('id');
            
            $ubs = new UserBusinessService();
            
            $user = $ubs->findById($id);
            
            // return user object to userProfilePage view
            return view('userProfilePage')->with(compact('user'));
        
        }catch(Exception $e2){
            Log::info("Exception ". array("message" => $e2->getMessage()));
            //Display Global Namespace Handler Page
            return view('SystemException');
        }
    }
    
    /**
     * openUpdateProfile method handle data from the home page
     and pass to UserBusinessService and return to
     the user profile page
     * @param Request $request
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function openUpdateProfile(Request $request)
    {
        try{
            $id = $request->input('id');
            
            $ubs = new UserBusinessService();
            
            //calls findById in the UserBusinessService
            $users = $ubs->findById($id);
            
            return view('userProfile')->with(compact('users'));
        
        }catch(Exception $e2){
            Log::info("Exception ". array("message" => $e2->getMessage()));
            //Display Global Namespace Handler Page
            return view('SystemException');
        }
    }
    
    /**
     * updateProfile method handles user profile update
     * request using UserBusinessService
     * @param Request $request
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory|string
     */
    public function updateProfile(Request $request)
    {
        try{
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
                $ubs = new UserBusinessService();
                
                // calls findById method in UserBusinessService and passes User Object
                $users = $ubs->findById($id);
                
                //return to view with model and errors
                return view('userProfile')->with(compact('users', 'errors'));
            }
            
            $updatedUser = new User($id, $username, $password, $firstname, $lastname, $email, $phonenumber, $city, $role, $status);
            
            //calls updateUser in UserBusinessService and pass $updateUser
            $ubs = new UserBusinessService();
            $result = $ubs->editUser($updatedUser);
            
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
        }catch(ValidationException $e1){
            throw ($e1);
        }catch(Exception $e2){
            Log::info("Exception ". array("message" => $e2->getMessage()));
            //Display Global Namespace Handler Page
            return view('SystemException');
        }
     }
    
}