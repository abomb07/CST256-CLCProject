<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Exception;
use App\Model\DTO;
use App\Services\Business\UserBusinessService;

class UserRestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try
        {
            $service = new UserBusinessService();
            $users = $service->findAllUsers();
            
            if(count($users) > 100)
            {
                $shortArr = array_slice($users, 0, 100);
                $dto = new DTO(-3, "Not all users displayed. Showing " . count($shortArr) . " users.", $shortArr);
            }
            else {
                $dto = new DTO(0, "Request successfull. All users displayed", $users);
            }
            
            //$json = json_encode($dto, JSON_PRETTY_PRINT);
            $json = Response::json($dto, 200, array(), JSON_PRETTY_PRINT);
            
            return $json;
        }
        catch (Exception $e)
        {
            Log::error("Exception: ", array("message" => $e->getMessage()));
            
            $dto = new DTO(-2, $e->getMessage(), "");
            return json_encode($dto, JSON_PRETTY_PRINT);
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
            $service = new UserBusinessService();
            $user = $service->findById($id);
            
            if($user == null)
                $dto = new DTO(-1, "USER NOT FOUND", "");
                else
                    $dto = new DTO(0, "Request successful. User ID " . $user->getId() . " displayed.", $user);
                    
                    $json = Response::json($dto, 200, array(), JSON_PRETTY_PRINT);
                    
                    return $json;
        }
        catch (Exception $e)
        {
            Log::error("Exception: ", array("message" => $e->getMessage()));
            
            $dto = new DTO(-2, $e->getMessage(), "");
            return json_encode($dto, JSON_PRETTY_PRINT);
        }
    }
}
