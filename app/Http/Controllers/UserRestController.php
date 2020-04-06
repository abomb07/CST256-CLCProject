<?php
/*
 * CLC Project version 6.0
 * User REST Controller version 6.0
 * Adam Bender and Jim Nguyen
 * April 5, 2020
 * User REST Controller handles User REST API
 */
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Response;
use Exception;
use App\Model\DTO;
use App\Services\Business\UserBusinessService;
use App\Services\Utility\ILoggerService;

class UserRestController extends Controller
{
    protected $logger;
    
    public function __construct(ILoggerService $logger)
    {
        $this->logger = $logger;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //this was not required but it returns all users in json format
        try
        {
            $service = new UserBusinessService();
            $users = $service->findAllUsers();
            
            if(count($users) > 100)
            {
                $shortArr = array_slice($users, 0, 100);
                $dto = new DTO(-3, "Not all users displayed. Showing " . count($shortArr) . " users.", $shortArr);
                
                $json = Response::json($dto, 413, array(), JSON_PRETTY_PRINT);
            }
            else {
                $dto = new DTO(0, "Request successfull. All users displayed", $users);
                
                $json = Response::json($dto, 200, array(), JSON_PRETTY_PRINT);
            }
            
            //$json = json_encode($dto, JSON_PRETTY_PRINT);
            
            
            return $json;
        }
        catch (Exception $e)
        {
            $this->logger->error("Exception: ", array("message" => $e->getMessage()));
            
            $dto = new DTO(-2, $e->getMessage(), "");
            
            $json = Response::json($dto, 500, array(), JSON_PRETTY_PRINT);
            return $json;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try
        {
            //find specific user
            $service = new UserBusinessService();
            $user = $service->findById($id);
            
            if($user == null)
            {
                //dto if user is not found
                $dto = new DTO(-1, "USER NOT FOUND", "");
                
                $json = Response::json($dto, 404, array(), JSON_PRETTY_PRINT);
            }
            else
            {
                //dto if user is found
                $dto = new DTO(0, "Request successful. User ID " . $user->getId() . " displayed.", $user);
                
                $json = Response::json($dto, 200, array(), JSON_PRETTY_PRINT);
            }
                    
            return $json;
        }
        catch (Exception $e)
        {
            $this->logger->error("Exception: ", array("message" => $e->getMessage()));
            
            $dto = new DTO(-2, $e->getMessage(), "");
            
            $json = Response::json($dto, 500, array(), JSON_PRETTY_PRINT);
            return $json;
        }
    }
}
