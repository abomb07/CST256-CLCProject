<?php
/* CLC Project version 3.0
 * Education version 3.0
 * Adam Bender and Jim Nguyen
 * February 23, 2020
 * Education class acts as a Model
 */
namespace App\Model;

class Education
{
    private $id;
    private $school;
    private $degree;
    private $field;
    private $graduationyear;
    private $user_id;
    
    public function __construct($id, $school, $degree, $field, $graduationyear, $user_id){
        $this->id = $id;
        $this->school = $school;
        $this->degree = $degree;
        $this->field = $field;
        $this->graduationyear = $graduationyear;
        $this->user_id = $user_id;
    }
    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getSchool()
    {
        return $this->school;
    }

    /**
     * @return mixed
     */
    public function getDegree()
    {
        return $this->degree;
    }

    /**
     * @return mixed
     */
    public function getField()
    {
        return $this->field;
    }

    /**
     * @return mixed
     */
    public function getGraduationyear()
    {
        return $this->graduationyear;
    }

    /**
     * @return mixed
     */
    public function getUser_id()
    {
        return $this->user_id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @param mixed $school
     */
    public function setSchool($school)
    {
        $this->school = $school;
    }

    /**
     * @param mixed $degree
     */
    public function setDegree($degree)
    {
        $this->degree = $degree;
    }

    /**
     * @param mixed $field
     */
    public function setField($field)
    {
        $this->field = $field;
    }

    /**
     * @param mixed $graduationyear
     */
    public function setGraduationyear($graduationyear)
    {
        $this->graduationyear = $graduationyear;
    }

    /**
     * @param mixed $user_id
     */
    public function setUser_id($user_id)
    {
        $this->user_id = $user_id;
    }
    
    
}

