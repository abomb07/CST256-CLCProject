<?php
/*
 * CLC Project version 5.0
 * GroupController version 5.0
 * Adam Bender and Jim Nguyen
 * March 15, 2020
 * Group Controller handles group functionalities
 */
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Exception;
use App\Model\Group;
use App\Services\Business\GroupBusinessService;
use Validator;
use App\Services\Business\UserBusinessService;
use App\Services\Utility\ILoggerService;
use App\Model\Member;

class GroupController extends Controller
{
    protected $logger;
    
    public function __construct(ILoggerService $logger)
    {
        $this->logger = $logger;
    }
    
    /**
     * createGroup method handles data from New Group Form
     * @param Request $request
     * @return string|\Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function createGroup(Request $request)
    {
        try
        {
            $this->validateNewGroupForm($request);
            //Get posted form data
            $name = $request->input('name');
            $description = $request->input('description');
            $owner_id = $request->input('owner_id');            
            
            $group = new Group(0, $name, $description, $owner_id);
            $gbs = new GroupBusinessService();
            $ubs = new UserBusinessService();
            
            //check for duplicate names
            if($gbs->findByGroupName($name) == null)
            {
                $result = $gbs->addGroup($group);
            }
            else
            {
                $error = "Group name already exists. Please choose a different name.";
                return view(('errorPage'),compact(['error']));
            }
            
            
            if($result)
            {
                //get id of group just created
                $theGroup = $gbs->findByGroupName($name);
                $group_id = $theGroup->getId();
                
                //create member for the owner
                $member = new Member(0, $group_id, $owner_id);
                $gbs->joinGroup($member);
                
                //find all groups to return to groupPage form
                $groups = $gbs->findAllGroups();
                
                return view(('groupPage'),compact(['groups']));
                
            }else
            {
                $error = "Create group unsuccessfully";
                return view(('errorPage'),compact(['error']));
            }
        }catch(ValidationException $e1){
            throw ($e1);
        }catch(Exception $e2){
            $this->logger->error("Exception ". array("message" => $e2->getMessage()));
            //Display Global Namespace Handler Page
            return view('SystemException');
        }
    }
    
    /**
     * findAllGroups method finds all group in database
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function findAllGroups()
    {
        try{
            $gbs = new GroupBusinessService();
            
            // calls findAllGroups in Business Service
            $groups = $gbs->findAllGroups();
    
            return view(('groupPage'),compact(['groups']));
        }catch(Exception $e2){
            $this->logger->error("Exception ". array("message" => $e2->getMessage()));
            //Display Global Namespace Handler Page
            return view('SystemException');
        }
    }
    
    /**
     * viewGroup method handles data from New Group Form
     * @param Request $request
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function viewGroup(Request $request)
    {   
        try{
            //Get posted form data
            $group_id = $request->input('group_id');
            $user_id = $request->input('user_id');
            
            $gbs = new GroupBusinessService();
            $ubs = new UserBusinessService();
            
            //calls findByGroupId in the MemberBusinessService to get all members in the group
            $members = $gbs->findAllMembers($group_id);
            
            //calls findById in the GroupBusinessService to get group information
            $group = $gbs->findById($group_id);
            
            //calls findById in the UserBusinessService to get owner information
            $owner = $ubs->findById($group->getOwner_id());
            
            if($members)
            {
                //create array of user objects in the group
                for ($i = 0; $i < count($members); $i++) 
                {
                    $users[$i] = $ubs->findById($members[$i]->getId());
                }
                
                //loop through members to check if the session user is already in the group
                if($users)
                {
                    for ($i = 0; $i < count($members); $i++) 
                    {                    
                        if($users[$i]->getId() == $user_id)
                        {
                            $memberExists = true;
                            break;
                        }
                        else {
                            $memberExists = false;
                        }
                    }
                }
            }
            else
            {
                $users = array();
            }
            return view(('groupViewMembersPage'),compact(['group'], ['users'],['owner'], ['memberExists'])); 
        }catch(ValidationException $e1){
            throw ($e1);
        }catch(Exception $e2){
            $this->logger->error("Exception ". array("message" => $e2->getMessage()));
            //Display Global Namespace Handler Page
            return view('SystemException');
        }
    }
    
    /**
     * openUpdateGroup method renders group data
     * @param Request $request
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory|string
     */
    public function openUpdateGroup(Request $request)
    {
        try
        {
            //Get posted Form data
            $id = $request->input('group_id');
            
            $gbs = new GroupBusinessService();
            
            // calls findById method in GroupBusinessService and passes id
            if($group = $gbs->findById($id))
            {
                return view('groupEditForm')->with(compact('group'));
            }else
            {
                $error = "Group not found. Please try again";
                return view(('errorPage'),compact(['error']));
            }
            
        }catch(Exception $e2){
            $this->logger->error("Exception ". array("message" => $e2->getMessage()));
            //Display Global Namespace Handler Page
            return view('SystemException');
        }
    }
    
    /**
     * updateGroup method handles data from Group Edit Form
     * @param Request $request
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory|string
     */
    public function updateGroup(Request $request)
    {
        try{
            //Get posted form data
            $id = $request->input('group_id');
            $name = $request->input('name');
            $description = $request->input('description');
            $owner_id = $request->input('owner_id');
            
            //Make validator rules
            $validator = Validator::make($request->all(), ['group_id' => 'Required',
                'name'=> 'Required|max:256',
                'description' => 'Required',
                'owner_id' => 'Required',
            ]);
            
            //if there is a validation error, reroute to form with errors and model
            if($validator->fails())
            {
                $errors = $validator->errors();
                
                $gbs = new GroupBusinessService();
                
                // calls findById method in JobBusinessService and passes Job Object
                $group = $gbs->findById($id);
                
                //return to view with model and errors
                return view('groupEditForm')->with(compact('group', 'errors'));
            }
            
            //Save posted Form Data to Group Object Model
            $updatedGroup = new Group($id, $name, $description, $owner_id);
            
            $gbs = new GroupBusinessService();
            
            //calls updateGroup in the GroupBusinessService
            $result = $gbs->editGroup($updatedGroup);
            
            // if success returns to adminJobs, else returns error message
            if($result)
            {
                $groups = $gbs->findAllGroups();
                
                return view(('groupPage'),compact(['groups']));
            }
            else
            {
                $error = "Update group information unsuccessfully. Please try again";
                return view(('errorPage'),compact(['error']));
            }
        }catch(ValidationException $e1){
            throw ($e1);
        }catch(Exception $e2){
            $this->logger->error("Exception ". array("message" => $e2->getMessage()));
            //Display Global Namespace Handler Page
            return view('SystemException');
        }
    }
    
    /**
     * processDeleteGroup method handles delete process 
     * @param Request $request
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function processDelete(Request $request)
    {
        try{
            //Get posted Form data
            $id = $request->input('group_id');
            
            $gbs = new GroupBusinessService();
            
            // calls findById method in GroupBusinessService and passes Group Object
            $group = $gbs->findById($id);
            
            return view('groupDeleteForm')->with(compact('group'));
        }catch(Exception $e2){
            $this->logger->error("Exception ". array("message" => $e2->getMessage()));
            //Display Global Namespace Handler Page
            return view('SystemException');
        }
    }
    
    /**
     * deleteGroup method deletes group from database
     * @param Request $request
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory|string
     */
    public function deleteGroup(Request $request)
    {
        try
        {
            //Get posted Form data
            $id = $request->input('group_id');
            
            //Save posted Form Data to Group Object Model
            $theGroup = new Group($id, "", "", "");
            $gbs = new GroupBusinessService();
              
            
            // calls deleteByGroupId method in the MemberBusinessService and passes group id
            $result1 = $gbs->deleteGroupMembers($id);
            
            // calls deleteGroup method in GroupBusinessService and passes Group Object
            $result = $gbs->deleteGroup($theGroup);
                        
            //if both succeed, return to groupPage, else return error message
            if($result && $result1)
            {
                $groups = $gbs->findAllGroups();
                
                return view(('groupPage'),compact(['groups']));
            }
            else
            {
                $error = "Unable to delete group. Please try again!";
                return view(('errorPage'),compact(['error']));
            }
            
        }catch(Exception $e2){
            $this->logger->error("Exception ". array("message" => $e2->getMessage()));
            //Display Global Namespace Handler Page
            return view('SystemException');
        }
    }
    
    /**
     * joinGroup method adds user to group in member data table
     * @param Request $request
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */ 
    public function joinGroup(Request $request)
    {
        try{
            //Get posted Form data
            $group_id = $request->input('group_id');
            $user_id = $request->input('user_id');
            
            //create new Member object
            $member = new Member(0, $group_id, $user_id);
            
            $gbs = new GroupBusinessService();
            //pass member object into createMember in the MemberBusinessService
            $result = $gbs->joinGroup($member);
            
            if($result)
            {
               
                $ubs = new UserBusinessService();
                
                //get all members in the group
                $members = $gbs->findAllMembers($group_id);
                
                //group information
                $group = $gbs->findById($group_id);
                
                //owner information
                $owner = $ubs->findById($group->getOwner_id());
                
                if($members)
                {
                    //create array of user objects in the group
                    for ($i = 0; $i < count($members); $i++)
                    {
                        $users[$i] = $ubs->findById($members[$i]->getId());
                    }
                    
                    //loop through members to check if the session user is already in the group
                    if($users)
                    {
                        for ($i = 0; $i < count($members); $i++)
                        {
                            if($users[$i]->getId() == $user_id)
                            {
                                $memberExists = true;
                                break;
                            }
                            else {
                                $memberExists = false;
                            }
                        }
                    }
                }
                else
                {
                    $users = array();
                }
                return view(('groupViewMembersPage'),compact(['group'], ['users'],['owner'], ['memberExists'])); 
            }
        }catch(Exception $e2){
            $this->logger->error("Exception ". array("message" => $e2->getMessage()));
            //Display Global Namespace Handler Page
            return view('SystemException');
        }
    }
    
    /**
     * leaveGroup method deletes user to group in member data table 
     * @param Request $request
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function leaveGroup(Request $request)
    {
        try{
            $group_id = $request->input('group_id');
            $user_id = $request->input('user_id');
            
            $member = new Member(0, $group_id, $user_id);

            $gbs = new GroupBusinessService();
            $ubs = new UserBusinessService();
           
            //group information
            $group = $gbs->findById($group_id);
            //owner information
            $owner = $ubs->findById($group->getOwner_id());
            
            //owner cant leave their own group
            if($owner->getId() == $user_id)
            {
                $error = "Owner can not leave their own group";
                return view(('errorPage'),compact(['error']));
            }
            
            $result = $gbs->leaveGroup($member);
            
            if($result)
            {
                //members in the group
                $members = $gbs->findAllMembers($group_id);
                
                if($members)
                {
                    //create array of user objects in the group
                    for ($i = 0; $i < count($members); $i++)
                    {
                        $users[$i] = $ubs->findById($members[$i]->getId());
                    }
                    
                    //loop through members to check if the session user is already in the group
                    if($users)
                    {
                        for ($i = 0; $i < count($members); $i++)
                        {
                            if($users[$i]->getId() == $user_id)
                            {
                                // if finds member, set memberExists to true
                                $memberExists = true;
                                break;
                            }
                            else {
                                // else set memberExists to false
                                $memberExists = false;
                            }
                        }
                    }
                }
                else
                {
                    $users = array();
                }
                return view(('groupViewMembersPage'),compact(['group'], ['users'],['owner'], ['memberExists']));
            }
        }catch(Exception $e2){
            $this->logger->error("Exception ". array("message" => $e2->getMessage()));
            //Display Global Namespace Handler Page
            return view('SystemException');
        }
    }
    
    /**
     * validateNewGroupForm method handles data validation in New Group Form
     * @param Request $request
     */
    private function validateNewGroupForm(Request $request){
        
        // data validation rules for  New Group Form
        $rules = ['name'=> 'Required|max:256',
            'description' => 'Required',
            'owner_id' => 'Required'
        ];
        
        // Run Data Validation Rules
        $this->validate($request, $rules);
    }
    
}
