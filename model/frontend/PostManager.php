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
        $req = $this->db->prepare("SELECT blogPostId, blogPostTitle, blogPostContents, blogPostStatus
        FROM blog_post ORDER BY blogPostUpdateDate DESC LIMIT ?, ?");
        
        $req->bindParam(1, $index, \PDO::PARAM_INT);
        $req->bindParam(2, $interval, \PDO::PARAM_INT);
        $req->execute();

        $req->setFetchMode(\PDO::FETCH_CLASS|\PDO::FETCH_PROPS_LATE, BlogPost::class);

        $posts = $req->fetchAll();
        return $posts;
    }

    public function getAllPosts()
    {   
        $req = $this->db->query("SELECT blogPostId, blogPostTitle, blogPostContents, blogPostStatus
        FROM blog_post ORDER BY blogPostUpdateDate DESC");
        
        $req->setFetchMode(\PDO::FETCH_CLASS|\PDO::FETCH_PROPS_LATE, BlogPost::class);

        $posts = $req->fetchAll();
        return $posts;
    }
    public function getPost($postId)
    {   
        $req = $this->db->prepare('SELECT blogPostId, blogPostTitle, blogPostContents, DATE_FORMAT(blogPostUpdateDate, \'%d/%m/%Y à %Hh%i\') AS creationDateFr 
        FROM blog_post WHERE blogPostId = ?');
        $req->bindParam(1, $postId, \PDO::PARAM_INT);
        $req->execute();

        $req->setFetchMode(\PDO::FETCH_CLASS|\PDO::FETCH_PROPS_LATE, BlogPost::class);
        
        $onePost = $req->fetchAll();
        return $onePost;
    }
    
}