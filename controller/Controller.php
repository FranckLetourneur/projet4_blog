<?php
namespace fletour\controller;

class controller 
{ 
    public static function listPosts()
    {
        $postManager = new \fletour\model\PostManager(); // Création d'un objet
        $posts = $postManager->getPosts(); // Appel d'une fonction de cet objet
        
        if (isset($_SESSION['userRole']) && $_SESSION['userRole'] == 0)
        {
            if (isset($_GET['list']))
            {
                require('view/listPostsView.php');
            }
            else
            {
                $commentManager = new \fletour\model\CommentManagerAdmin();
                $comments = $commentManager->getComments();

                require('view/back/adminHome.php');  
            }
           
        }
        else
        {
            require('view/listPostsView.php');
        }
       
    }

    public static function post()
    {
        $postManager = new \fletour\model\PostManager();
        $commentManager = new \fletour\model\CommentManager();

        $posts = $postManager->getPost($_GET['id']);
        $comments = $commentManager->getComments($_GET['id']);

        require('view/postView.php');
    }

    public static function addComment($idUser, $commentAuthor, $postId, $comment, $startingCommentId)
    {
        $idUser = htmlspecialchars(strip_tags($idUser));
        $commentAuthor = htmlspecialchars(strip_tags($commentAuthor));
        $postId = htmlspecialchars(strip_tags($postId));
        $comment = htmlspecialchars(strip_tags($comment));
        $startingCommentId = htmlspecialchars(strip_tags($startingCommentId));  

        $connexionManager = new \fletour\model\ConnexionManager();
        $userInformation = $connexionManager->checkConnexion($commentAuthor);

        if (isset($userInformation['userPseudo']))
        {
            throw new \Exception( ' Vous avez essayé de poster un commentaire sous un nom enregistré. S\'il s\'agit du votre, <a href="http://localhost:8888/blog_Jean_Forteroche/index.php?action=connexion">connectez-vous </a>, merci !');

        }

        $commentManager = new \fletour\model\CommentManager();
        $comments = $commentManager->addComment($idUser, $commentAuthor, $postId, $comment, $startingCommentId);
        if ($startingCommentId != 0 && $_SESSION['userRole'] == 0)
        {
            header('Location: index.php?action=commentsAdmin');
        }
        else
        {
            header('Location: index.php?action=post&id='.$postId.'');
        }
        exit();
        
    }

   
    public static function moderate()
    {
        $commentId = htmlspecialchars($_GET['commentId']);
        $commentManager = new \fletour\model\CommentManager();
        $comments = $commentManager->updatecommentReport($commentId);
        
        header('Location: index.php?action=post&id='.$_GET['id'].'');
    }

    public static function connexion()
    {
        require('view/connexionView.php');
    }

    public static function checkConnexion()
    {   if (isset($_POST['userName']) && isset($_POST['userMdp']) )
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
            
            $connexionManager = new \fletour\model\ConnexionManager();
            $userInformation = $connexionManager->checkConnexion($userName);

            $isPasswordCorrect = password_verify($userMdp, $userInformation['userPassword']);
    
            if (isset($userInformation['userId']))
            {
                    if ($isPasswordCorrect) 
                    {
                        $_SESSION['userPseudo'] = $userInformation['userPseudo'];
                        $_SESSION['userRole'] = $userInformation['userRole'];
                        $_SESSION['userId'] = $userInformation['userId'];
                        header('Location: index.php');

                    }
                    else 
                    {
                        throw new \Exception( 'Mauvais MdP !');
                    }
                
            }
            else
            {
                    //user unkwon
                    header('Location: index.php?action=userRegistration');
            }
            
        }

       
        
        else
        {
            throw new \Exception('formulaire mal rempli');
        }
        
    }

    
    public static function userRegistration()
    {
       
        require('view/userRegistrationView.php');
    }

    public static function userCreate()
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
                $connexionManager = new \fletour\model\ConnexionManager();
                $userInformation = $connexionManager->checkConnexion($userName);
                
                if (isset($userInformation['userPseudo']))
                {
                    throw new \Exception('Ce pseudo existe déjà, merci de choisir un autre pseudo<br><a href="javascript:history.back()">C\'est par ici !</a>');
                }
                else
                { 
                   
                    $userInformation = $connexionManager->addUser($_POST['userName'], $userMdp_hash, $_POST['userMail']);
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
    {   //session_start();
        $_SESSION = array();
        session_destroy();
        header('Location: index.php');

    }
}