<?php
/* CLC Project version 3.0
 * User version 3.0
 * Adam Bender and Jim Nguyen
 * February 19th, 2020
 * Credential class acts as a Model
 */
namespace App\Model;

class Credential
{
    private $username;
    private $password;
    
    public function __construct($username, $password){
        $this->username = $username;
        $this->password = $password;
    }
    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    
    
    
}

