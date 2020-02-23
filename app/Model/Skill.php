<?php
/* CLC Project version 3.0
 * Skill version 3.0
 * Adam Bender and Jim Nguyen
 * February 19th, 2020
 * Skill class acts as a Model
 */
namespace App\Model;

class Skill
{
    private $id;
    private $skill;
    private $user_id;
    
    public function __construct($id , $skill, $user_id){
        $this->id = $id;
        $this->skill = $skill;
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
    public function getSkill()
    {
        return $this->skill;
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
     * @param mixed $skill
     */
    public function setSkill($skill)
    {
        $this->skill = $skill;
    }

    /**
     * @param mixed $user_id
     */
    public function setUser_id($user_id)
    {
        $this->user_id = $user_id;
    }

    
}

