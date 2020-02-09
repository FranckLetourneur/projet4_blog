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
    {   if (isset($_POST['userName']) && isset($_POST['userMdp']))
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
                $userMdp = password_hash(htmlspecialchars(strip_tags($_POST['userMdp'])), PASSWORD_DEFAULT);
            }
            else
            {
                $userMdp = "";
            }            
        }

        if (!empty($userName) && !empty($userMdp))
        {
            $connexionManager = new \fletour\model\ConnexionManager();
            $connexionManager->checkConnexion($userName, $userMdp);
        }
        else
        {
            throw new \Exception('formulaire mal rempli');
        }
        
    }
}