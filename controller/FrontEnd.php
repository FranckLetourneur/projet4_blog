<?php
namespace fletour\controller;

class FrontEnd {

    public static function listPosts()
    {
        $postManager = new \fletour\model\frontend\PostManager(); 
        $posts = $postManager->getPosts(); 
        if (isset($_SESSION['userRole']) && $_SESSION['userRole'] == 0)
        {
            if (isset($_GET['list']))
            {
                require('view/frontend/listPostsView.php');
            }
            else
            {
                $commentManager = new \fletour\model\backend\CommentManagerBackEnd();
                $comments = $commentManager->getComments();

                require('view/backend/adminHome.php');  
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

    public static function post()
    {
        $postManager = new \fletour\model\frontend\PostManager();
        $posts = $postManager->getPost($_GET['id']);

        $commentManager = new \fletour\model\frontend\CommentManager();
        $comments = $commentManager->getComments($_GET['id']);
        require('view/frontend/postView.php');
    }

    public static function addComment($idUser, $commentAuthor, $postId, $comment, $startingCommentId)
    {   
        $idUser = htmlspecialchars(strip_tags($idUser));
        $commentAuthor = htmlspecialchars(strip_tags($commentAuthor));
        $postId = htmlspecialchars(strip_tags($postId));
        $comment = htmlspecialchars(strip_tags($comment));
        $startingCommentId = htmlspecialchars(strip_tags($startingCommentId));  

        $connexionManager = new \fletour\model\frontend\ConnexionManager();
        $userInformation = $connexionManager->checkConnexion($commentAuthor);
       
        if (isset($userInformation['userPseudo']))
        {
            throw new \Exception( ' Vous avez essayé de poster un commentaire sous un nom enregistré. S\'il s\'agit du votre, <a href="connexion">connectez-vous </a>, merci !');

        }

        $commentManager = new \fletour\model\frontend\CommentManager();
        $comments = $commentManager->addComment($idUser, $commentAuthor, $postId, $comment, $startingCommentId);

        if ($startingCommentId != 0 && $_SESSION['userRole'] == 0)
        {
            header('Location: commentsAdmin');
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
        $commentManager = new \fletour\model\frontend\CommentManager();
        $comments = $commentManager->updatecommentReport($commentId);
        
        header('Location: index.php?action=post&id='.$_GET['id'].'');
    }

    public static function checkConnexion()
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
            
            $connexionManager = new \fletour\model\frontend\ConnexionManager();
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

    public static function userRegistration()
    {
       require('view/frontend/userRegistrationView.php');
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
                $connexionManager = new \fletour\model\frontend\ConnexionManager();
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
}