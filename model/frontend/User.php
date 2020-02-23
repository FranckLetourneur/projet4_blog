<?php
namespace fletour\model\frontend;

class User {
    private $userId;
    private $userPseudo;
    private $userPassword;
    private $userMail;
    private $registrationDate;
    private $lastConnexionDate;
    private $lastBlogPostRead;
    private $userRole;

    //setters
    public function setUserId($id)
    {
        $id = (int) $id;
        if ($id > 0) {$this->userId = $id;}
    }
    public function setUserPseudo($pseudo)
    { 
        if (is_string($pseudo)) { $this->userPseudo = $pseudo;}
    }
    public function setUserPassword ($mdp)
    {
        if (is_string($mdp)) { $this->userPassword = $mdp;}
    }
    public function setUserMail ($email)
    {
        if (is_string($email)) { $this->userMail = $email;}
    }
    public function setRegistrationDate($date)
    {
        $this->registrationDate = $date;
    }
    public function setLastConnexionDate($date)
    {
        $this->lastConnexionDate = $date;
    }
    public function setLastBlogPostRead($id)
    {
        $id = (int) $id;
        if (is_int($id)) { $this->lastBlogPostRead = $id;}
    }
    public function setUserRole($id) 
    {
        $id = (int) $id;
        if (is_int($id)) { $this->userRole = $id;}
    }

    //getters
    public function getuserId()
    {
        return $this->userId;
    }
    public function getUserPseudo()
    {
        return $this->userPseudo;
    }               
    public function getUserPassword()
    {                
        return $this->userPassword;
    }
    public function getUserMail()
    {
        return $this->userMail;
    }
    public function getRegistrationDate()
    {
        return $this->registrationDate;
    }
    public function getLastConnexionDate()
    {
        return $this->lastConnexionDate;
    }
    public function getLastBlogPostRead()
    {
        return $this->lastBlogPostRead;
    }
    public function getUserRole()
    {
        return $this->userRole;
    }
    
}