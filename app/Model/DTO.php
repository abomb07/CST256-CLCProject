<?php
/* CLC Project version 6.0
 * DTO version 6.0
 * Adam Bender and Jim Nguyen
 * April 5, 2020
 * DTO class acts as a Model
 */
namespace App\Model;

class DTO implements \JsonSerializable
{
    private $errorCode;
    private $errorMessage;
    private $data;
    
    public function __construct($errorCode, $errorMessage, $data)
    {
        $this->errorCode = $errorCode;
        $this->errorMessage = $errorMessage;
        $this->data = $data;
    }
    
    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}

