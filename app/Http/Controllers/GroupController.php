<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Exception;
use App\Model\Group;
use App\Services\Business\GroupBusinessService;
use App\Services\Data\GroupDataService;
use Validator;
use App\Services\Business\MemberBusinessService;
use App\Services\Business\UserBusinessService;
use App\Model\Member;
class GroupController extends Controller
{
    // createGroup method handles data from New Group Form
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
            $result = $gbs->createGroup($group);
            if($result){
               
                $groups = $gbs->findAllGroups();
               
                return view(('groupPage'),compact(['groups']));
            }else{
                 return "Create group unsuccessfully";
            }
        }catch(ValidationException $e1){
            throw ($e1);
        }catch(Exception $e2){
            Log::info("Exception ". array("message" => $e2->getMessage()));
            //Display Global Namespace Handler Page
            return view('SystemException');
        }
        
    }
    
    // fidnAllGroups method finds all group in database
    public function findAllGroups()
    {
        $gbs = new GroupBusinessService();
        $groups = $gbs->findAllGroups();

        // calls findAllGroups in Business Service
        if($groups != null)
        {
            return view(('groupPage'),compact(['groups']));
        }
        else
        {
            return view('groupPage');
        }
        
    }
    
    // viewGroup method handles data from New Group Form
    public function viewGroup(Request $request)
    {   
        
        $group_id = $request->input('group_id');
        $user_id = $request->input('user_id');
        
        $mbs = new MemberBusinessService();
        $gbs = new GroupBusinessService();
        $ubs = new UserBusinessService();
        
        //members in the group
        $members = $mbs->findByGroupId($group_id);
        //group information
        $group = $gbs->findById($group_id);
        
        $owner = $ubs->findById($group->getOwner_id());
        if($members)
        {
            for ($i = 0; $i < count($members); $i++) {
                $users[$i] = $ubs->findById($members[$i]->getId());
                
                if($users[$i]->getId() == $user_id)
                {
                    $memberExists = true;
                }
                else {
                    $memberExists = false;
                }
            }
        }
        else
        {
            $users = array();
        }
        return view(('groupViewMembersPage'),compact(['group'], ['users'],['owner'], ['memberExists'])); 
        
    }
    
    // openUpdateGroup method renders group data
    public function openUpdateGroup(Request $request){
        try
        {
            //Get posted Form data
            $id = $request->input('group_id');
            
            //Save posted Form Data to Job Object Model
            
            $gbs = new GroupBusinessService();
            
            // calls findById method in JobBusinessService and passes Job Object
            if($group = $gbs->findById($id)){
                
                //if success, return to adminEditJobForm, else return error message
                return view('groupEditForm')->with(compact('group'));
            }else{
                return "Group not found. Please try again";
            }
            
        }catch(Exception $e2){
            Log::info("Exception ". array("message" => $e2->getMessage()));
            //Display Global Namespace Handler Page
            return view('SystemException');
        }
    }
    
    // updateGroup method handles data from Group Edit Form
    public function updateGroup(Request $request){
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
            
            //Save posted Form Data to Job Object Model
            $updatedGroup = new Group($id, $name, $description, $owner_id);
            
            // calls findById method in JobBusinessService and passes Job object
            $gbs = new GroupBusinessService();
            $ubs = new UserBusinessService();
            $result = $gbs->updateGroup($updatedGroup);
            
            // if success returns to adminJobs, else returns error message
            if($result)
            {
                $groups = $gbs->findAllGroups();
                
                return view(('groupPage'),compact(['groups']));
            }
            else
            {
                return "Update group information unsuccessfully. Please try again";
            }
            
        }catch(Exception $e2){
            Log::info("Exception ". array("message" => $e2->getMessage()));
            //Display Global Namespace Handler Page
            return view('SystemException');
        }
    }
    
    // processDeleteGroup method handles delete process 
    public function processDelete(Request $request)
    {
        //Get posted Form data
        $id = $request->input('group_id');
        
        
        $gbs = new GroupBusinessService();
        
        // calls findById method in GroupBusinessService and passes Group Object
        $group = $gbs->findById($id);
        
        return view('groupDeleteForm')->with(compact('group'));
    }
    
    // deleteGroup method deletes group from database
    public function deleteGroup(Request $request)
    {
        try
        {
            //Get posted Form data
            $id = $request->input('group_id');
            
            //Save posted Form Data to Group Object Model
            $theGroup = new Group($id, "", "", "");
            $gbs = new GroupBusinessService();
            // calls deleteUser method in GroupBusinessService and passes Group Object
            $result = $gbs->deleteGroup($theGroup);
            
            
            //if success, return to groupPage, else return error message
            if($result)
            {
                
                $groups = $gbs->findAllGroups();
                
                return view(('groupPage'),compact(['groups']));
            }
            else
            {
                return "Unable to delete group. Please try again!";
            }
            
        }catch(Exception $e2){
            Log::info("Exception ". array("message" => $e2->getMessage()));
            //Display Global Namespace Handler Page
            return view('SystemException');
        }
    }
    
    // joinGroup method adds user to group in member data table 
    public function joinGroup(Request $request)
    {
        $group_id = $request->input('group_id');
        $user_id = $request->input('user_id');
        
        $member = new Member(0, $group_id, $user_id);
        
        $mbs = new MemberBusinessService();
        $result = $mbs->createMember($member);
        
        if($result)
        {
            $gbs = new GroupBusinessService();
            $ubs = new UserBusinessService();
            
            //members in the group
            $members = $mbs->findByGroupId($group_id);
            //group information
            $group = $gbs->findById($group_id);
            
            $owner = $ubs->findById($group->getOwner_id());
            if($members)
            {
                for ($i = 0; $i < count($members); $i++) {
                    $users[$i] = $ubs->findById($members[$i]->getId());
                    
                    if($users[$i]->getId() == $user_id)
                    {
                        $memberExists = true;
                    }
                    else {
                        $memberExists = false;
                    }
                }
            }
            else
            {
                $users = array();
            }
            return view(('groupViewMembersPage'),compact(['group'], ['users'],['owner'], ['memberExists'])); 
        }
        
    }
    
    // leaveGroup method deletes user to group in member data table 
    public function leaveGroup(Request $request)
    {
        $group_id = $request->input('group_id');
        $user_id = $request->input('user_id');
        
        $member = new Member(0, $group_id, $user_id);
        
        $mbs = new MemberBusinessService();
        $result = $mbs->deleteMember($member);
        
        if($result)
        {
            $gbs = new GroupBusinessService();
            $ubs = new UserBusinessService();
            
            //members in the group
            $members = $mbs->findByGroupId($group_id);
            //group information
            $group = $gbs->findById($group_id);
            
            $owner = $ubs->findById($group->getOwner_id());
            if($members)
            {
                for ($i = 0; $i < count($members); $i++) {
                    $users[$i] = $ubs->findById($members[$i]->getId());
                    
                    if($users[$i]->getId() == $user_id)
                    {
                        $memberExists = true;
                    }
                    else {
                        $memberExists = false;
                    }
                }
            }
            else
            {
                $users = array();
            }
            return view(('groupViewMembersPage'),compact(['group'], ['users'],['owner'], ['memberExists']));
        }
        
    }
    
    /* validateGroupForm method handles data validation in New Group Form
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
