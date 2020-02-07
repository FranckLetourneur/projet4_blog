<?php
//require_once('model/PostManager.php');
require_once('model/CommentManager.php');


class controller 
{ 
    public static function listPosts()
    {
        $postManager = new \fletour\Blog\model\PostManager(); // Création d'un objet
        $posts = $postManager->getPosts(); // Appel d'une fonction de cet objet
    
        require('view/listPostsView.php');
    }

    public static function post()
    {
        $postManager = new \fletour\Blog\model\PostManager();
        $commentManager = new \fletour\Blog\model\CommentManager();

        $posts = $postManager->getPost($_GET['id']);
        $comments = $commentManager->getComments($_GET['id']);

        require('view/postView.php');
    }

    public static function addComment($idUser, $author, $postId, $comment)
    {
        $idUser = htmlspecialchars($idUser);
        $author = htmlspecialchars($author);
        $postId = htmlspecialchars($postId);
        $comment = htmlspecialchars($comment);
        //ajouter une verif si connecté ou non
        $commentManager = new \fletour\Blog\model\CommentManager();
        $comments = $commentManager->addComment($idUser, $author, $postId, $comment);
        header('Location: index.php?action=post&id='.$postId.'');
        exit();
        
    }

    public static function moderate()
    {
        $comment_id = htmlspecialchars($_GET['comment_id']);
        $commentManager = new \fletour\Blog\model\CommentManager();
        $comments = $commentManager->updateReport($comment_id);
        
        header('Location: index.php?action=post&id='.$_GET['id'].'');
    }
}