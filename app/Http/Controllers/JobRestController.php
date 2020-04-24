<?php
/*
 * CLC Project version 6.0
 * Job REST Controller version 6.0
 * Adam Bender and Jim Nguyen
 * April 17, 2020
 * Job REST Controller handles Job REST API
 */
namespace App\Http\Controllers;

use App\Model\DTO;
use App\Services\Business\JobBusinessService;
use App\Services\Utility\ILoggerService;
use Illuminate\Support\Facades\Response;
use Exception;

class JobRestController extends Controller
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
        try
        {
            //find all jobs
            $service = new JobBusinessService();
            $jobs = $service->findAllJobs();
            
            //if more than 100 jobs exist, only return the first 100
            if(count($jobs) > 100)
            {
                //slice array to 100 elements
                $shortArr = array_slice($jobs, 0, 100);
                
                // dto object with result message and dto code
                $dto = new DTO(-3, "Not all jobs displayed. Showing " . count($shortArr) . " jobs.", $shortArr);
                
                // json object with formated array and HTTP code
                $json = Response::json($dto, 413, array(), JSON_PRETTY_PRINT);
            }
            else {
                // dto object with result message and dto code
                $dto = new DTO(0, "Request successfull. All jobs displayed", $jobs);
                
                // json object with formated array and HTTP code
                $json = Response::json($dto, 200, array(), JSON_PRETTY_PRINT);
            }
            
            //return json object
            return $json;
        }
        catch (Exception $e)
        {
            $this->logger->error("Exception: ", array("message" => $e->getMessage()));
            
            // dto object with result message and dto code
            $dto = new DTO(-2, $e->getMessage(), "");
            
            // json object with formated array and HTTP code
            $json = Response::json($dto, 500, array(), JSON_PRETTY_PRINT);
            
            //return json object
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
            //find specific job
            $service = new JobBusinessService();
            $jobs = $service->findById($id);
            
            if($jobs == null)
            {
                //data transfer object if id is invalid
                $dto = new DTO(-1, "JOB NOT FOUND", "");
                
                // json object with formated array and HTTP code
                $json = Response::json($dto, 404, array(), JSON_PRETTY_PRINT);
            }
            else
            {
                // dto object with result message and dto code
                $dto = new DTO(0, "Request successful. Job ID " . $jobs->getId() . " displayed.", $jobs);
                
                //json formatting
                $json = Response::json($dto, 200, array(), JSON_PRETTY_PRINT);
            }
                //return json object
                return $json;
        }
        catch (Exception $e)
        {
            $this->logger->error("Exception: ", array("message" => $e->getMessage()));
            
            // dto object with result message and dto code
            $dto = new DTO(-2, $e->getMessage(), "");
            
            // json object with formated array and HTTP code
            $json = Response::json($dto, 500, array(), JSON_PRETTY_PRINT);
            return $json;
        }
    }
}
