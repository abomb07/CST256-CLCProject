<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*
 * this route is mapped to the '/home' URI render to 
 * the Home Page (an HTML Form)
 */
Route::get('/home', function () {
    return view('homePage');
});
    
/*
* this route is mapped to the '/login' URI render to the Login Form
* View (an HTML Form) 
*/
Route::get('/login', function()
{
    return view('loginForm');
});


/*
 * this route is mapped to the '/login' URI render to 
 * the Register Form view (an HTML Form)
 */
Route::get('/register', function()
{
    return view('registerForm');
});

/*
 * this route is mapped to the '/processRegister' URI and will
 * process the Register Form POST request in the RegisterController
 */
Route::post('/processRegister', 'RegisterController@register');

/*
 * this route is mapped to the '/processLogin' URI and will
 * process the Login Form POST request in the LoginController
 */
Route::post('/processLogin', 'LoginController@login');

/*
 * this route is mapped to the '/loginSuccess' URI renders to the 
 * loginSuccess Form (an HTML Form)
 */
Route::get('/loginSuccess', function()
{
    return view('loginSuccess');
});

/*
 * this route is mapped to the '/loginFailed' URI renders to the 
 * loginSuccess Form (an HTML Form)
 */
Route::get('/loginFailed', function()
{
    return view('loginFailed');
});




