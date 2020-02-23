<?php
/*
 * CLC Project version 3.0
 * New Skill Form version 3.0
 * Adam Bender and Jim Nguyen
 * February 23, 2020
 * DatabaseException handles job handles data exception
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

