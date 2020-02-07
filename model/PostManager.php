<?php
namespace fletour\model;

//require_once("model/Manager.php");

class PostManager extends Manager
{
  

    public function getPosts()
    {
        $db = $this->dbConnect();

        $req = $db->query('SELECT id_post, title_post, contents_post, DATE_FORMAT(date_update_post, \'%d/%m/%Y à %Hh%imin%ss\') AS creation_date_fr FROM blog_post ORDER BY date_update_post DESC LIMIT 0, 5');
        return $req;
    }

    public function getPost($postId)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT id_post, title_post, contents_post, DATE_FORMAT(date_update_post, \'%d/%m/%Y à %Hh%imin%ss\') AS creation_date_fr FROM blog_post WHERE id_post = ?');

        $req->execute(array($postId));
        return $req;
    }
}
