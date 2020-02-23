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
Route::get('/', function () {
    return view('homePage');
});

/*
 * this route is mapped to the '/home' URI render to 
 * the Home Page (an HTML Form)
 */
Route::get('/home', 'JobController@findAllFeaturedJobs');
    
/*
* this route is mapped to the '/login' URI render to the Login Form
* View (an HTML Form) 
*/
Route::get('/login', function()
{
    return view('loginForm');
});

/*
 * this route is mapped to the '/register' URI render to 
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
Route::post('/processRegister', 'AccountController@register');

/*
 * this route is mapped to the '/processLogin' URI and will
 * process the Login Form POST request in the LoginController
 */
Route::post('/processLogin', 'AccountController@login');

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

/*
 * this route is mapped to the '/loginSuccess' URI renders to the
 * loginSuccess Form (an HTML Form)
 */
Route::get('/loginSuspended', function()
{
    return view('loginSuspended');
});

/*
 * this route is mapped to the '/loginSuccess' URI renders to the
 * loginSuccess Form (an HTML Form)
 */
Route::get('/registerExisted', function()
{
    return view('registerExisted');
});
/*
 * this route is mapped to the '/admin' URI renders to the
 * admin Form (an HTML Form)
 */
Route::get('/admin', 'AdminController@getUsers');

/*
 * this route is mapped to the '/processUserProfileEdit' URI 
 * and processes the user profile update
 */
Route::post('/processUserProfileEdit','ProfileController@updateProfile');

/*
 * this route is mapped to the '/adminEdit' URI and will
 * process the Admin Form POST request in the AdminController
 */
Route::post('/adminEdit','AdminController@openUpdateUser');

/*
 * this route is mapped to the '/adminSave' URI and will
 * process the Admin Edit Form POST request in the AdminController
 */
Route::post('/adminSave','AdminController@updateUser');

/*
 * this route is mapped to the '/adminDelete' URI and will
 * process the Admin Edit Form Delete button POST request in the AdminController
 */
Route::post('/adminDelete','AdminController@deleteUser');

/*
 * this route is mapped to the '/adminConfirmDelete' URI and will
 * process to processDeleteUser in the AdminController
 */
Route::post('/adminConfirmDelete','AdminController@processDeleteUser');
/*
 * this route is mapped to the '/logout' URI renders to the
 * Home Page Form (an HTML Form)
 * it also destroys all session data
 */
Route::get('/logout','AccountController@logout');

/*
 * this route is mapped to the '/adminSuspend' URI and will
 * process to suspendUser in the AdminController
 */
Route::post('/adminSuspend','AdminController@suspendUser');

/*
 * this route is mapped to the '/adminActivate' URI and will
 * process to activateUser in the AdminController
 */
Route::post('/adminActivate','AdminController@activateUser');

/*
 * this route is mapped to the '/adminSearch' URI renders to the
 * adminSearchForm Form (an HTML Form)
 */
Route::get('/adminSearch', function()
{
    return view('adminSearchForm');
});

/*
 * this route is mapped to the '/findByFirstName' URI and will
 * process to findByFirstName in the AdminController
 */
Route::post('/findByFirstName','AdminController@findByFirstName');

/*
 * this route is mapped to the '/findByLastName' URI and will
 * process to findByLastName in the AdminController
 */
Route::post('/findByLastName','AdminController@findByLastName');

/*========= Milestone 3 =======*/

Route::get('/adminNewJobForm', function()
{
    return view('adminNewJobForm');
});

/*
 * this route is mapped to the '/userPortfolioNewJobHistory' URI renders to the
 * userPortfolioNewJobHistory Form (an HTML Form)
 */
Route::get('/userPortfolioNewJobHistory', function()
{
    return view('userPortfolioNewJobHistory');
});


/*
 * this route is mapped to the '/userPortfolioNewEducation' URI renders to the
 * userPortfolioNewEducation Form (an HTML Form)
 */
Route::get('/userPortfolioNewEducation', function()
{
    return view('userPortfolioNewEducation');
});

/*
 * this route is mapped to the '/userPortfolioNewSkill' URI renders to the
 * userPortfolioNewSkill Form (an HTML Form)
 */
Route::get('/userPortfolioNewSkill', function()
{
    return view('userPortfolioNewSkill');
});

/*
 * this route is mapped to the '/addJobHistory' URI renders to the
 * userPortfolioNewJobHistory Form (an HTML Form)
 */
Route::post('/addJobHistory', 'JobHistoryController@createJobHistory');

/*
 * this route is mapped to the '/addJobHistory' URI renders to the
 * userPortfolioNewSkill Form (an HTML Form)
 */
Route::post('/addSkill', 'SkillController@createSkill');

/*
 * this route is mapped to the '/addEducation' URI renders to the
 * userPortfolioNewEducation Form (an HTML Form)
 */
Route::post('/addEducation', 'EducationController@createEducation');

/*
 * this route is mapped to the '/newJobPosting' URI renders to the
 * admin New Job Form (an HTML Form)
 */
Route::post('/newJobPosting', 'JobController@createJob');
/*
 * this route is mapped to the '/admin' URI renders to the
 * admin Form (an HTML Form)
 */
Route::post('/profile', 'ProfileController@openProfile');

/*
 * this route is mapped to the '/editProfile' URI renders to the
 * User Profile Edit Form (an HTML Form)
 */
Route::post('/editProfile','ProfileController@openUpdateProfile');

/*
 * this route is mapped to the '/adminJobs' URI renders to the
 * admin jobs Form (an HTML Form)
 */
Route::get('/adminJobs', 'JobController@findAllJobs');

/*
 * this route is mapped to the '/adminJobEdit' URI renders to the
 * Admin Job Edit Form (an HTML Form)
 */
Route::post('/adminJobEdit','JobController@openUpdateJob');

/*
 * this route is mapped to the '/editJobPosting' URI and will
 * update the job in the database
 */
Route::post('/editJobPosting','JobController@updateJob');

/*
 * this route is mapped to the '/adminConfirmJobDelete' URI renders to the
 * Admin Job Delete Confirmation Form (an HTML Form)
 */
Route::post('/adminConfirmJobDelete','JobController@processDeleteJob');

/*
 * this route is mapped to the '/adminJobDelete' URI and will
 * delete the job in the database
 */
Route::post('/adminJobDelete','JobController@deleteJob');

/*
 * this route is mapped to the '/portfolio' URI renders to the
 * User Portfolio Form (an HTML Form)
 */
Route::post('/portfolio', 'AccountController@findPortfolio');

/*
 * this route is mapped to the '/editJobHistory' URI renders to the
 * Portfolio Job History Edit Form (an HTML Form)
 */
Route::post('/editJobHistory','JobHistoryController@openUpdateJobHistory');

/*
 * this route is mapped to the '/editSkill' URI renders to the
 * Portfolio Skill Edit Form (an HTML Form)
 */
Route::post('/editSkill','SkillController@openUpdateSkill');

/*
 * this route is mapped to the '/editEducation' URI renders to the
 * Portfolio Education Edit Form (an HTML Form)
 */
Route::post('/editEducation','EducationController@openUpdateEducation');

/*
 * this route is mapped to the '/updateJobHistory' URI and will
 * update the user job history in the database
 */
Route::post('/updateJobHistory','JobHistoryController@updateJobHistory');

/*
 * this route is mapped to the '/updateSkill' URI and will
 * update the user skill in the database
 */
Route::post('/updateSkill','SkillController@updateSkill');

/*
 * this route is mapped to the '/updateEducation' URI and will
 * update the user education in the database
 */
Route::post('/updateEducation','EducationController@updateEducation');

/*
 * this route is mapped to the '/deleteJobHistory' URI renders to the
 * Job History Delete Confirmation Form (an HTML Form)
 */
Route::post('/deleteJobHistory','JobHistoryController@processDelete');

/*
 * this route is mapped to the '/deleteSkill' URI renders to the
 * Skill Delete Confirmation Form (an HTML Form)
 */
Route::post('/deleteSkill','SkillController@processDelete');

/*
 * this route is mapped to the '/deleteEducation' URI renders to the
 * Education Delete Confirmation Form (an HTML Form)
 */
Route::post('/deleteEducation','EducationController@processDelete');

/*
 * this route is mapped to the '/removeJobHistory' URI and will
 * delete the user job history in the database
 */
Route::post('/removeJobHistory','JobHistoryController@deleteJobHistory');

/*
 * this route is mapped to the '/removeSkill' URI and will
 * delete the user skill in the database
 */
Route::post('/removeSkill','SkillController@deleteSkill');

/*
 * this route is mapped to the '/removeEducation' URI and will
 * delete the user education in the database
 */
Route::post('/removeEducation','EducationController@deleteEducation');