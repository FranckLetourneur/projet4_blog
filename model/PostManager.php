<?php
namespace fletour\model;

class PostManager extends Manager
{
  

    public function getPosts()
    {
        $db = $this->dbConnect();

        $req = $db->query('SELECT blogPostId, blogPostTitle, blogPostContents, DATE_FORMAT(blogPostUpdateDate, \'%d/%m/%Y à %Hh%imin%ss\') AS creation_date_fr , blogPostStatus 
        FROM blog_post ORDER BY blogPostUpdateDate DESC');
        return $req;
    }

    public function getPost($postId)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT blogPostId, blogPostTitle, blogPostContents, DATE_FORMAT(blogPostUpdateDate, \'%d/%m/%Y à %Hh%imin%ss\') AS creation_date_fr 
        FROM blog_post WHERE blogPostId = ?');

        $req->execute(array($postId));
        return $req;
    }
}
