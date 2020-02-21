<?php
namespace fletour\controller;

class FrontEnd {

    protected $db;
    private $postManager;

    public function __construct(\PDO $db) {
        $this->db = $db;
    }

    public function listPosts($recup)
    {   
        $currentPage = intval($recup);
        $this->postManager = new \fletour\model\frontend\PostManager($this->db);
        
        $numberOfBlogPost = $this->postManager->getCount();

        $blogPostPerPage = 3;
        $firstBlogPostIdOfPage = ($currentPage -1) * $blogPostPerPage;
        $numberOfPages = ceil($numberOfBlogPost/$blogPostPerPage);

        if ($currentPage > $numberOfPages){
            header ('Location: index.php?action=listPosts&page=1');
        }  
        
        $posts = $this->postManager->getPosts($firstBlogPostIdOfPage, $blogPostPerPage); 
        if (isset($_SESSION['userRole']) && $_SESSION['userRole'] == 0)
        {
            if (isset($_GET['list']))
            {
                require('view/frontend/listPostsView.php');
            }
            else
            {
             //   $commentManager = new \fletour\model\backend\CommentManagerBackEnd();
             //   $comments = $commentManager->getComments();

             //   require('view/backend/adminHome.php');  
            }
        }
        else
        {
           require('view/frontend/listPostsView.php');
        }
       
    }
    

    public static function deconnexion()
    {   
        $_SESSION = array();
        session_destroy();
        header('Location: index.php');
    }


}