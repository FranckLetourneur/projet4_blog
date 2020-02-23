<?php
namespace fletour\model\frontend;

class UserManager {

    protected $db;

    public function __construct(\PDO $db) {
        $this->db = $db;
    }
    
    public function checkConnexion($userName)
    {            
        $req = $this->db->prepare('SELECT userId, userPseudo, userPassword, userRole FROM user WHERE userPseudo = ?');
        $req->bindParam(1, $userName, \PDO::PARAM_STR);
        $req->execute();

        $req->setFetchMode(\PDO::FETCH_CLASS|\PDO::FETCH_PROPS_LATE, User::class);

        $userInformation = $req->fetch();
        
        if (is_object($userInformation))
        {
            $this->updateLastConnexionDate($userInformation->getUserId());
        }
        return $userInformation;

    }

    public function addUser($userName, $userMdp, $userMail)
    {
        $user = $this->db->prepare('INSERT INTO user(userPseudo, userPassword, userMail, registrationDate, lastConnexionDate, userRole) VALUES(?, ?, ?, NOW(), NOW(), ?)');

        $affectedLines = $user->execute(array($userName, $userMdp, $userMail, 9));
        return $affectedLines;
    }

    protected function updateLastConnexionDate ($userId) {
        $user = $this->db->prepare('UPDATE user SET lastConnexionDate = NOW() WHERE userId = ?');
        $affectedLines = $user->execute(array($userId));
        return $affectedLines;
    }

    public function userAdmin()
    {
        $req = $this->db->query('SELECT userId, userPseudo, lastBlogPostRead,
            registrationDate, lastConnexionDate
            FROM user 
            WHERE userId > 10
            ORDER BY lastConnexionDate');
        $req->setFetchMode(\PDO::FETCH_CLASS|\PDO::FETCH_PROPS_LATE, User::class);

        $userInformation = $req->fetchAll();

        return $userInformation;
    }
    
    public function eraseUser($id) 
    {
        $req = $this->db->prepare('DELETE FROM user WHERE userId = ?');
        $req->bindParam(1, $id, \PDO::PARAM_INT);
        $affectedLines = $req->execute();
        return $affectedLines;    
    }

    public function updateLastPostRead($userId, $blogPostId)
    {
        $user = $this->db->prepare('UPDATE user SET lastBlogPostRead = ? WHERE userId = ?');
        $affectedLines = $user->execute(array($blogPostId, $userId));
        return $affectedLines;
    }



}