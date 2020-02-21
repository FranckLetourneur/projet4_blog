<?php
namespace fletour\model\frontend;

class PostManager {
    
    protected $db;

    public function __construct(\PDO $db) {
        $this->db = $db;
    }

    public function getCount()
    {
        
        $req = $this->db->query("SELECT COUNT(blogPostId) AS numberOfBlogPost 
                            FROM blog_post WHERE blogPostStatus = 'inRead' " );
        $count = $req->fetch();
        
        $numberOfBlogPost = $count['numberOfBlogPost'];
        return $numberOfBlogPost;
    }

    public function getPosts($index, $interval)
    {   
       // $lien = '\fletour\model\BlogPost()';
        $req = $this->db->query("SELECT blogPostId, blogPostTitle, blogPostContents, blogPostStatus 
        FROM blog_post ORDER BY blogPostUpdateDate DESC LIMIT $index, $interval");
        
      //  $req->setFetchMode(\PDO::FETCH_CLASS|\PDO::FETCH_PROPS_LATE, BlogPost::BlogPost);
      //  $req->setFetchMode(\PDO::FETCH_CLASS|\PDO::FETCH_PROPS_LATE, "$lien");
        $posts = $req->fetchAll(\PDO::FETCH_CLASS|\PDO::FETCH_PROPS_LATE,'\fletour\model\frontend\BlogPost');
        return $posts;
    }
}