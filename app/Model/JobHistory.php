<?php
/* CLC Project version 4.0
 * JobHistory version 4.0
 * Adam Bender and Jim Nguyen
 * March 8, 2020
 * Job History class acts as a Model
 */
namespace App\Model;

class JobHistory
{
    private $id;
    private $title;
    private $company;
    private $startdate;
    private $enddate;
    private $user_id;
    
    public function __construct($id, $title, $company, $startdate, $enddate, $user_id){
        $this->id = $id;
        $this->title = $title;
        $this->company = $company;
        $this->startdate = $startdate;
        $this->enddate = $enddate;
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
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return mixed
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * @return mixed
     */
    public function getStartdate()
    {
        return $this->startdate;
    }

    /**
     * @return mixed
     */
    public function getEnddate()
    {
        return $this->enddate;
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
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @param mixed $company
     */
    public function setCompany($company)
    {
        $this->company = $company;
    }

    /**
     * @param mixed $startdate
     */
    public function setStartdate($startdate)
    {
        $this->startdate = $startdate;
    }

    /**
     * @param mixed $enddate
     */
    public function setEnddate($enddate)
    {
        $this->enddate = $enddate;
    }

    /**
     * @param mixed $user_id
     */
    public function setUser_id($user_id)
    {
        $this->user_id = $user_id;
    }
    
}

