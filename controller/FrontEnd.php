<?php
namespace fletour\controller;

class FrontEnd {

    protected $db;
    private $postManager;
    private $commentManager;
    private $userManager;

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
        
        
        
        if (isset($_SESSION['userRole']) && $_SESSION['userRole'] == 0)
        {
            if (isset($_GET['list']))
            {
                $posts = $this->postManager->getPosts($firstBlogPostIdOfPage, $blogPostPerPage); 
                require('view/frontend/listPostsView.php');
            }
            else
            {
                $posts = $this->postManager->getAllPosts(); 

                $this->commentManager = new \fletour\model\backend\CommentManagerBackEnd($this->db);
                $comments = $this->commentManager->getComments();
                require('view/backend/adminHome.php');  
            }
        }
        else
        {
            $posts = $this->postManager->getPosts($firstBlogPostIdOfPage, $blogPostPerPage);
            require('view/frontend/listPostsView.php');
        }
       
    }
    
    public function post($blogPostId)
    {    
        if (isset($_SESSION['userId']))
        {
            $this->userManager = new \fletour\model\frontend\UserManager($this->db);
            $user = $this->userManager->updateLastPostRead($_SESSION['userId'], $_GET['id']);
        } 
        $this->postManager = new \fletour\model\frontend\PostManager($this->db);
        $onePost = $this->postManager->getPost($blogPostId); 
        
        $this->commentManager = new \fletour\model\frontend\CommentManager($this->db);
        $comments = $this->commentManager->getComments($blogPostId);
            
        require('view/frontend/postView.php');
    }

    public function addComment($idUser, $commentAuthor, $postId, $comment, $startingCommentId)
    {   
        $idUser = htmlspecialchars(strip_tags($idUser));
        $commentAuthor = htmlspecialchars(strip_tags($commentAuthor));
        $postId = htmlspecialchars(strip_tags($postId));
        $comment = htmlspecialchars(strip_tags($comment));
        $startingCommentId = htmlspecialchars(strip_tags($startingCommentId));  

        $this->userManager = new \fletour\model\frontend\UserManager($this->db);
        $userInformation = $this->userManager->checkConnexion($commentAuthor);
        if ($userInformation != false)
        {
            if ($userInformation->getUserPseudo() != NULL)
            {
                throw new \Exception( ' Vous avez essayé de poster un commentaire sous un nom enregistré. S\'il s\'agit du votre, <a href="connexion">connectez-vous </a>, merci !');
            }
        }
        

        $this->commentManager = new \fletour\model\frontend\CommentManager($this->db);
        $comments = $this->commentManager->addComment($idUser, $commentAuthor, $postId, $comment, $startingCommentId);
    

        if ($startingCommentId != 0 && $_SESSION['userRole'] == 0)
        {
            header('Location: commentsAdmin');
        }
        else
        {
            header('Location: index.php?action=post&id='.$postId.'');
        }
       
    }

    public function moderate()
    {
        $commentId = htmlspecialchars($_GET['commentId']);
        $this->commentManager = new \fletour\model\frontend\CommentManager($this->db);
        $comments = $this->commentManager->updatecommentReport($commentId);
        
        header('Location: index.php?action=post&id='.$_GET['id'].'');
    }

    public function checkConnexion()
    {   
        if (isset($_POST['userName']) && isset($_POST['userMdp']) )
        {
            if ($_POST['userName'] === htmlspecialchars(strip_tags($_POST['userName'])))
            {
                $userName = htmlspecialchars(strip_tags($_POST['userName']));
            }
            else
            {
                $userName = "";
            }

            if ($_POST['userMdp'] === htmlspecialchars(strip_tags($_POST['userMdp'])))
            {
                $userMdp = htmlspecialchars(strip_tags($_POST['userMdp']));
                $userMdp_hash = password_hash($userMdp, PASSWORD_DEFAULT);
            }
            else
            {
                $userMdp = "";
            }
            $this->userManager = new \fletour\model\frontend\UserManager($this->db);
            $userInformation = $this->userManager->checkConnexion($userName);
    
            if (is_object($userInformation))
            {
                $isPasswordCorrect = password_verify($userMdp, $userInformation->getUserPassword());
                if ($isPasswordCorrect) 
                {
                    $_SESSION['userPseudo'] = $userInformation->getUserPseudo();
                    $_SESSION['userRole'] = $userInformation->getUserRole();
                    $_SESSION['userId'] = $userInformation->getUserId();
                    header('Location: index.php');
                }
                else 
                {
                    throw new \Exception( 'Soit le nom, soit le mot de passe est faux!');
                }
            }
            else
            {
                    //user unkwon
                    header('Location: userRegistration');
            }
            
        }        
        else
        {
            throw new \Exception('formulaire mal rempli');
        }

    }

    public function userRegistration()
    {
       require('view/frontend/userRegistrationView.php');
    }

    public function userCreate()
    {   
        if (isset($_POST['userName']) && isset($_POST['userMdp']) && isset($_POST['userMail']))
        {
            if ($_POST['userName'] === htmlspecialchars(strip_tags($_POST['userName'])))
            {
                $userName = htmlspecialchars(strip_tags($_POST['userName']));
            }
            else
            {
                $userName = "";
            }

            if ($_POST['userMdp'] === htmlspecialchars(strip_tags($_POST['userMdp'])) )
            {
                $userMdp = htmlspecialchars(strip_tags($_POST['userMdp']));
                $userMdp_hash = password_hash($userMdp, PASSWORD_DEFAULT);
            }
            else
            {
                $userMdp = "";
            }
            
            if ($_POST['userMail'] === htmlspecialchars(strip_tags($_POST['userMail'])))
            {
                $userMdp = htmlspecialchars(strip_tags($_POST['userMdp']));
            }
            else
            {
                $userMail = "";
            }

            if (!empty($_POST['userName']) && !empty($_POST['userMdp']) && !empty($_POST['userMail']))
            {
                $this->userManager = new \fletour\model\frontend\UserManager($this->db);
                $userInformation = $this->userManager->checkConnexion($userName);
                
                
                if (is_object($userInformation))
                {
                    throw new \Exception('Ce pseudo existe déjà, merci de choisir un autre pseudo<br><a href="javascript:history.back()">C\'est par ici !</a>');
                }
                else
                { 
                   
                    $userInformation = $this->userManager->addUser($_POST['userName'], $userMdp_hash, $_POST['userMail']);
                    throw new \Exception('enregistrement réalisé, <br>merci de vous connecter <a href="index.php?action=connexion">ici !</a>');
                }
            }
            else
            {
                throw new \Exception('Merci de remplir tout les champs.<br><a href="javascript:history.back()">C\'est par ici !</a>' );
            }
            
        }
    }

    public static function deconnexion()
    {   
        $_SESSION = array();
        session_destroy();
        header('Location: index.php');
    }


}