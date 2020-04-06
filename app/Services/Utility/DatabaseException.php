<?php
/*
 * CLC Project version 6.0
 * DatabaseException version 6.0
 * Adam Bender and Jim Nguyen
 * April 5, 2020
 * DatabaseException handles job handles data exception
 */
namespace App\Services\Utility;

use Exception;

class DatabaseException extends Exception
{
    /**
     * Non default constructor
     * @param $message
     * @param number $code
     * @param Exception $previous
     */
    public function __construct($message, $code = 0, Exception $previous = null){
        
        // Call super class
        parent:: __construct($message, $code, $previous);
    }
}

