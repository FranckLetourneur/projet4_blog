<?php
namespace fletour\controller;

class controllerBack 
{ 
    public static function commentsAdmin()
    {
        $commentManager = new \fletour\model\CommentManagerAdmin();

        $comments = $commentManager->getComments();

        require('view/back/commentsViewAdmin.php');
    }

    public static function commentsValidate($id)
    {
        $commentManager = new \fletour\model\CommentManagerAdmin();
        $comments = $commentManager->updatecommentReport($id);

        header('Location: index.php?action=commentsAdmin');

    } 

    public static function commentsModify($id)
    {   
        $commentManager = new \fletour\model\CommentManagerAdmin();
        $comments = $commentManager->getOneComment($id);
        if ($comments['answerId'] != 0)
        {
            require('view/back/answerModify.php');
        }
        else
        {
            require('view/back/commentsModify.php');
        }
        
    }

    public static function commentUpdate($id, $content) {
        $commentManager = new \fletour\model\CommentManagerAdmin();
        $comments = $commentManager->commentUpdateBdd($id, $content);
        header('Location: index.php?action=commentsAdmin');

    }

    public static function commentsDelete($id) {
        $commentManager = new \fletour\model\CommentManagerAdmin();
        $comments = $commentManager->commentDelete($id);

        header('Location: index.php?action=commentsAdmin');

    }

   public static function saveNewPost($blogPostTitle, $textPost) {
       $postManager = new \fletour\model\PostManagerAdmin();
       $post = $postManager->saveNewPost($blogPostTitle, $textPost);

       header('Location: index.php?action=listPosts');
   }
}