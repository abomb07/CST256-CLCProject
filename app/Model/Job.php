<?php
/* CLC Project version 4.0
 * Job version 4.0
 * Adam Bender and Jim Nguyen
 * April 17, 2020
 * Job class acts as a Model
 */
namespace App\Model;

class Job implements \JsonSerializable
{
    private $id;
    private $jobtitle;
    private $category;
    private $description;
    private $requirements;
    private $company;
    private $location;
    private $salary;

    public function __construct($id, $jobtitle, $category, $description, $requirements, $company, $location, $salary)
    {
        $this->id = $id;
        $this->jobtitle = $jobtitle;
        $this->category = $category;
        $this->description = $description;
        $this->requirements = $requirements;
        $this->company = $company;
        $this->location = $location;
        $this->salary = $salary;
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
    public function getJobtitle()
    {
        return $this->jobtitle;
    }

    /**
     * @return mixed
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return mixed
     */
    public function getRequirements()
    {
        return $this->requirements;
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
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @return mixed
     */
    public function getSalary()
    {
        return $this->salary;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @param mixed $jobtitle
     */
    public function setJobtitle($jobtitle)
    {
        $this->jobtitle = $jobtitle;
    }

    /**
     * @param mixed $category
     */
    public function setCategory($category)
    {
        $this->category = $category;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @param mixed $requirements
     */
    public function setRequirements($requirements)
    {
        $this->requirements = $requirements;
    }

    /**
     * @param mixed $company
     */
    public function setCompany($company)
    {
        $this->company = $company;
    }

    /**
     * @param mixed $location
     */
    public function setLocation($location)
    {
        $this->location = $location;
    }

    /**
     * @param mixed $salary
     */
    public function setSalary($salary)
    {
        $this->salary = $salary;
    }
    
    public function jsonSerialize()
    {
        return get_object_vars($this);
    }

    
}

