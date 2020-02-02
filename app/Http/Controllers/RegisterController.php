<?php
/* CLC Project version 1.0
 * RegisterController version 1.0
 * Adam Bender and Jim Nguyen
 * January 19th, 2020
 * Register renders data from Register Form
 */
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\User;
use App\Services\Business\UserBusinessService;

class RegisterController extends Controller
{
    /* register method handle data from Register Form
    and pass to UserBusinessService */
    public function register(Request $request)
    {
        //Display the Form Data
        $username = $request->input('username');
        $password = $request->input('password');
        $firstname = $request->input('firstname');
        $lastname = $request->input('lastname');
        $email = $request->input('email');
        $role = $request->input('role');
        
        $user = new User(0, $username, $password, $firstname, $lastname, $email, $role);
        $ubs = new UserBusinessService();
        
        //Create user and return to loginForm view
        if($ubs->createUser($user)){
            return view('loginForm');
        }
       
    }
}
