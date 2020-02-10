<?php
namespace fletour\model;

//require_once("model/Manager.php");

class PostManager extends Manager
{
  

    public function getPosts()
    {
        $db = $this->dbConnect();

        $req = $db->query('SELECT blogPostId, blogPostTitle, blogPostContents, DATE_FORMAT(blogPostUpdateDate, \'%d/%m/%Y à %Hh%imin%ss\') AS creation_date_fr FROM blog_post ORDER BY blogPostUpdateDate DESC LIMIT 0, 5');
        return $req;
    }

    public function getPost($postId)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT blogPostId, blogPostTitle, blogPostContents, DATE_FORMAT(blogPostUpdateDate, \'%d/%m/%Y à %Hh%imin%ss\') AS creation_date_fr FROM blog_post WHERE blogPostId = ?');

        $req->execute(array($postId));
        return $req;
    }
}
