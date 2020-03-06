<?php
/* CLC Project version 4.0
 * JobHistory version 4.0
 * Adam Bender and Jim Nguyen
 * March 8th, 2020
 * Group class acts as a Model
 */
namespace App\Model;

class Group{
    
    private $id;
    private $name;
    private $description;
    private $owner_id;
    
    public function __construct( $id, $name, $description, $owner_id){
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->owner_id = $owner_id;
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
    public function getName()
    {
        return $this->name;
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
    public function getOwner_id()
    {
        return $this->owner_id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @param mixed $owner_id
     */
    public function setOwner_id($owner_id)
    {
        $this->owner_id = $owner_id;
    }  
    
    
}