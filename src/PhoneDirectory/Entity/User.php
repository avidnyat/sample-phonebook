<?php

namespace PhoneDirectory\Entity;

class User
{
    /**
     * User id.
     *
     * @var integer
     */
    protected $id;

    /**
     * Username.
     *
     * @var string
     */
    protected $username;

    /**
     * User password.
     *
     * @var string
     */
    protected $password;

    
    /**
     * User Created time
     *
     * @var datetime
     */
    protected $dateCreated;
    
    /**
     * User Updated time
     *
     * @var datetime
     */
    protected $dateUpdated;

    
    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getUserName()
    {
        return $this->username;
    }

    public function setUserName($username)
    {
        $this->username = $username;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }
    public function getDateCreated()
    {
        return $this->dateCreated;
    }

    public function setDateCreated(\DateTime $dateCreated)
    {
        $this->dateCreated = $dateCreated;
    }
    
    public function getDateUpdated()
    {
        return $this->dateUpdated;
    }

    public function setDateUpdated(\DateTime $dateUpdated)
    {
        $this->dateUpdated = $dateUpdated;
    }
   
    
}
