<?php

namespace App\Http\Controllers;

use App\Model\DTO;
use App\Services\Business\JobBusinessService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Exception;

class JobRestController extends Controller
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
            $service = new JobBusinessService();
            $jobs = $service->findAllJobs();
            
            if(count($jobs) > 100)
            {
                $shortArr = array_slice($jobs, 0, 100);
                $dto = new DTO(-3, "Not all jobs displayed. Showing " . count($shortArr) . " jobs.", $shortArr);
            }
            else {
                $dto = new DTO(0, "Request successfull. All jobs displayed", $jobs);
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
            $service = new JobBusinessService();
            $jobs = $service->findById($id);
            
            if($jobs == null)
                $dto = new DTO(-1, "JOB NOT FOUND", "");
                else
                    $dto = new DTO(0, "Request successful. Job ID " . $jobs->getId() . " displayed.", $jobs);
                    
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
