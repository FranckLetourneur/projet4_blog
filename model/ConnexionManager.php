<?php
namespace fletour\model;

class ConnexionManager extends Manager
{
    public function checkConnexion($userName)
    {
        $db = $this->dbConnect();

        $req = $db->prepare('SELECT userId, userPseudo, userPassword, userRole FROM user WHERE userPseudo = ?');
        $req->execute(array($userName));
        $userInformation = $req->fetch();

        if (isset($userInformation['userPseudo']))
        {
            $this->updateLastConnexionDate($userInformation['userId']);
        }
        return $userInformation;
    }

    public function addUser($userName, $userMdp, $userMail)
    {
        $db = $this->dbConnect();
        $user = $db->prepare('INSERT INTO user(userPseudo, userPassword, userMail, registrationDate, lastConnexionDate, userRole) VALUES(?, ?, ?, NOW(), NOW(), ?)');

        $affectedLines = $user->execute(array($userName, $userMdp, $userMail, 9));
        return $affectedLines;
    }

    protected function updateLastConnexionDate ($userId) {
        $db = $this->dbConnect();
        $user = $db->prepare('UPDATE user SET lastConnexionDate = NOW() WHERE userId = ?');
        $affectedLines = $user->execute(array($userId));
        return $affectedLines;
    }

}