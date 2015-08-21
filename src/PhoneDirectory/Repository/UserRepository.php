<?php

namespace PhoneDirectory\Repository;

use Doctrine\DBAL\Connection;
use PhoneDirectory\Entity\PhoneBook;

/**
 * Phonebook repository
 */
class UserRepository 
{
    /**
     * @var \Doctrine\DBAL\Connection
     */
    protected $db;

    public function __construct(Connection $db)
    {
        $this->db = $db;
    }

    /**
     * Authenticates the user from API
     *
     * @param array $phoneBook
     */
    public function authenticate(array $responseData, $app)
    {
        $userData = $this->db->fetchAssoc('SELECT * FROM users WHERE username = ? and password = ?', array($responseData["username"], sha1($responseData["password"])));
        if($userData){
            $_session["username"] = $responseData['username'];
            $csrf = uniqid();
            $app['session']->set('user', $csrf);
            return array("csrf"=>$csrf);
        }else{
            return false;
        }
    }
   
}
