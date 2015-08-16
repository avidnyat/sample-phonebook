<?php

namespace PhoneDirectory\Entity;

class PhoneBook
{
    /**
     * PhoneBook id.
     *
     * @var integer
     */
    protected $id;

    /**
     * PhoneBook name.
     *
     * @var string
     */
    protected $name;

    /**
     * PhoneBook phone number.
     *
     * @var string
     */
    protected $phoneNumber;

    /**
     * PhoneBook additional notes.
     *
     * @var text
     */
    protected $additionalNotes;

    /**
     * PhoneBook Created time
     *
     * @var datetime
     */
    protected $dateCreated;
    
    /**
     * PhoneBook Updated time
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

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;
    }

    public function getAdditionalNotes()
    {
        return $this->additionalNotes;
    }

    public function setAdditionalNotes($additionalNotes)
    {
        $this->additionalNotes = $additionalNotes;
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
