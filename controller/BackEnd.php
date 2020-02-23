<?php
namespace fletour\controller;

class BackEnd {

    protected $db;
    private $postManager;
    private $commentManager;
    private $userManager;
    
    public function __construct(\PDO $db) {
        $this->db = $db;
    }

    public function saveNewPost($blogPostId, $blogPostTitle, $textPost)
    {
        $this->postManager = new \fletour\model\backend\PostManagerBackEnd($this->db);
        $post = $this->postManager->saveNewPost($blogPostId, $blogPostTitle, $textPost);

        if ($blogPostId == 0) {
            $this->postManager = new \fletour\model\backend\PostManagerBackEnd($this->db);
            $theLastPost = $this->postManager->lastPost();
            $blogPostId = $theLastPost['blogPostId'];
        }

        if ($_POST['bouton'] === 'quitter') {
            header('Location: listPosts');
        } elseif ($_POST['bouton'] === 'continuer') {
            header("Location: index.php?action=modifyPost&id=$blogPostId");
        }
    }

    public function modifyPost($id)
    {
        $this->postManager = new \fletour\model\frontend\PostManager($this->db);
        $post = $this->postManager->getPost($id);

        require('view/backend/newPost.php');
    }

    public function deletePost($id)
    {   
        $this->postManager = new \fletour\model\backend\PostManagerBackEnd($this->db);
        $post = $this->postManager->deletePost($id);

        header("Location: index.php");
    }

    public function unDeletePost($id)
    {
        $this->postManager = new \fletour\model\backend\PostManagerBackEnd($this->db);
        $post = $this->postManager->unDeletePost($id);

        require('view/backend/manageTrash.php');
    }

    public function modifyPostStatus($id)
    {
        $this->postManager = new \fletour\model\backend\PostManagerBackEnd($this->db);
        $post = $this->postManager->modifyPostStatus($id);
        header("Location: index.php");
    }

    public function updateBlogPostId($blogPostId, $newBlogPostId)
    {
        $newBlogPostId = intval($newBlogPostId);
        if (is_int($newBlogPostId)) {
            $this->postManager = new \fletour\model\backend\PostManagerBackEnd($this->db);
            $post = $this->postManager->updateBlogPostId($blogPostId, $newBlogPostId);

            $this->postManager = new \fletour\model\frontend\PostManager($this->db);
            $posts = $this->postManager->getAllPosts();
            require('view/backend/numberBlogPost.php');
        }
        else
        {
            throw new \Exception("Désolé, vous n'avez pas saisi un nombre entier");
        }
    }

    public function updateIncrementingBlogPost() {
        $this->postManager = new \fletour\model\backend\PostManagerBackEnd($this->db);
        $post = $this->postManager->updateIncrementingBlogPost();

        throw new \Exception("Votre base de données a été modifié. Choisissez une nouvelle activité dans le menu");
    }

    public function erasePost($id) {
        if (isset($id)) {
            $this->postManager = new \fletour\model\backend\PostManagerBackEnd($this->db);

            $post = $this->postManager->erasePost($id);
            header("Location: index.php?action=manageTrash");

        }
    }
    public  function listBlogPost()
    {
        $this->postManager = new \fletour\model\frontend\PostManager($this->db);
        $posts = $this->postManager->getAllPosts();

        require('view/backend/listBlogPost.php');
    }

    public  function commentsValidate($id)
    {
        $this->commentManager = new \fletour\model\backend\CommentManagerBackEnd($this->db);
        $comments = $this->commentManager->updatecommentReport($id);

        header('Location: commentsAdmin');
    }

    public  function commentsModify($id)
    {
        $this->commentManager = new \fletour\model\backend\CommentManagerBackEnd($this->db);
        $comments = $this->commentManager->getOneComment($id);

        if ($comments->getAnswerId() != 0) {
            require('view/backend/answerModify.php');
        } else {
            require('view/backend/commentsModify.php');
        }
    }

    public  function commentUpdate($id, $content)
    {
        $this->commentManager = new \fletour\model\backend\CommentManagerBackEnd($this->db);
        $comments = $this->commentManager->commentUpdateBdd($id, $content);

        header('Location: commentsAdmin');
    }

    public  function commentsDelete($id)
    {
        $this->commentManager = new \fletour\model\backend\CommentManagerBackEnd($this->db);
        $comments = $this->commentManager->commentDelete($id);

        header('Location: commentsAdmin');
    }

    public  function userAdmin() {
        $this->userManager = new \fletour\model\frontend\UserManager($this->db);
        $users = $this->userManager->userAdmin();

        require('view/backend/userAdmin.php');
    }

    public  function eraseUser($id) {

        $this->userManager = new \fletour\model\frontend\UserManager($this->db);
        $users = $this->userManager->eraseUser($id);
        header('Location: userAdmin');
    }

    public function numberBlogPost()
    {
        $this->postManager = new \fletour\model\frontend\PostManager($this->db);
        $posts = $this->postManager->getAllPosts();

        

        require('view/backend/numberBlogPost.php');
    }

    public  function manageTrash()
    {
        $this->postManager = new \fletour\model\frontend\PostManager($this->db);
        $posts = $this->postManager->getAllPosts();

        require('view/backend/manageTrash.php');
    }

    public  function commentsAdmin()
    {
        $this->commentManager = new \fletour\model\backend\CommentManagerBackEnd($this->db);
        $comments = $this->commentManager->getComments();

        require('view/backend/commentsViewAdmin.php');
    }
}