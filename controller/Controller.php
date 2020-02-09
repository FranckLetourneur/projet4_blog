<?php
namespace fletour\controller;

class controller 
{ 
    public static function listPosts()
    {
        $postManager = new \fletour\model\PostManager(); // Création d'un objet
        $posts = $postManager->getPosts(); // Appel d'une fonction de cet objet
    
        require('view/listPostsView.php');
    }

    public static function post()
    {
        $postManager = new \fletour\model\PostManager();
        $commentManager = new \fletour\model\CommentManager();

        $posts = $postManager->getPost($_GET['id']);
        $comments = $commentManager->getComments($_GET['id']);

        require('view/postView.php');
    }

    public static function addComment($idUser, $author, $postId, $comment)
    {
        $idUser = htmlspecialchars(strip_tags($idUser));
        $author = htmlspecialchars(strip_tags($author));
        $postId = htmlspecialchars(strip_tags($postId));
        $comment = htmlspecialchars(strip_tags($comment));
        //ajouter une verif si connecté ou non
        $commentManager = new \fletour\model\CommentManager();
        $comments = $commentManager->addComment($idUser, $author, $postId, $comment);
        header('Location: index.php?action=post&id='.$postId.'');
        exit();
        
    }

   
    public static function moderate()
    {
        $comment_id = htmlspecialchars($_GET['comment_id']);
        $commentManager = new \fletour\model\CommentManager();
        $comments = $commentManager->updateReport($comment_id);
        
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

            $isPasswordCorrect = password_verify($userMdp, $userInformation['password_user']);
    
            if (isset($userInformation['pseudo_user']))
            {
                    if ($isPasswordCorrect) 
                    {
                        echo "enfin";
                        session_start();
                        $_SESSION['pseudo_user'] = $userInformation['pseudo_user'];
                        $_SESSION['role_user'] = $userInformation['role_user'];
                        echo 'Vous êtes connecté !';
                    }
                    else 
                    {
                        throw new \Exception( 'Mauvais MdP !');
                    }
                
            }
            else
            {
                    //user inconnu
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
                
                if (isset($userInformation['pseudo_user']))
                {
                    throw new \Exception('Ce pseudo existe déjà, merci de choisir un autre pseudo<br><a href="javascript:history.back()">C\'est par ici !</a>');
                }
                else
                { 
                   
                    $userInformation = $connexionManager->addUser($_POST['userName'], $userMdp_hash, $_POST['userMail']);
                    throw new \Exception('enregistrement réalisé');
                }
            }
            else
            {
                throw new \Exception('Merci de remplir tout les champs.<br><a href="javascript:history.back()">C\'est par ici !</a>' );
            }
            
        }
    }
}