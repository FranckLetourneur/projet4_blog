<?php
namespace fletour\model;

class ConnexionManager extends Manager
{
    public function checkConnexion($userName)
    {
        $db = $this->dbConnect();

        $req = $db->prepare('SELECT id_user, pseudo_user, password_user, role_user FROM user WHERE pseudo_user = ?');
        $req->execute(array($userName));
        $userInformation = $req->fetch();

        return $userInformation;
    }

    public function addUser($userName, $userMdp, $userMail)
    {
        $db = $this->dbConnect();
        $user = $db->prepare('INSERT INTO user(pseudo_user, password_user, mail_user, registration_date, last_connection_date, role_user) VALUES(?, ?, ?, NOW(), NOW(), ?)');

        $affectedLines = $user->execute(array($userName, $userMdp, $userMail, 9));
        return $affectedLines;
    }

}