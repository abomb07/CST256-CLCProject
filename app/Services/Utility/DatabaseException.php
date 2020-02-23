<?php
/* CLC Project version 2.0
* DatabaseException version 2.0
* Adam Bender and Jim Nguyen
* February 5th, 2020
* DatabaseException class handles data exception 
*/
namespace App\Services\Utility;

use Exception;

class DatabaseException extends Exception
{
    //Non default constructor
    public function __construct($message, $code = 0, Exception $previous = null){
        
        // Call super class
        parent:: __construct($message, $code, $previous);
    }
}

