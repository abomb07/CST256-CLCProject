<?php
/* CLC Project version 1.0
 * LoginController version 1.0
 * Adam Bender and Jim Nguyen
 * January 19th, 2020
 * LoginController renders data from Login Form
 */
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Business\UserBusinessService;
use App\Model\Credential;
class LoginController extends Controller
{
    /* login method handle data from Login Form
     and pass to UserBusinessService */
    public function login(Request $request)
    {
        //Display the Form Data
        $username = $request->input('username');
        $password = $request->input('password');
        
        // authenticate user and return to loginSuccess 
        // if succeed or to loginFailed if failed
        $credential = new Credential($username, $password);
        $ubs = new UserBusinessService();
        if($ubs->findUser($credential)){
            return view('loginSuccess');
        }else{
            return view('loginFailed');
        }
            
        
    }
}
