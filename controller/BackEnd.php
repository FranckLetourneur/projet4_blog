<?php
namespace fletour\controller;

class BackEnd {

    public static function listBlogPost()
    {
        $postManager = new \fletour\model\frontend\PostManager();
        $posts = $postManager->getPosts();

        require('view/backend/listBlogPost.php');
    }

    public static function numberBlogPost()
    {
        $postManager = new \fletour\model\frontend\PostManager();
        $posts = $postManager->getPosts();

        require('view/backend/numberBlogPost.php');
    }

    public static function manageTrash()
    {
        $postManager = new \fletour\model\frontend\PostManager();
        $posts = $postManager->getPosts();

        require('view/backend/manageTrash.php');
    }

    public static function commentsAdmin()
    {
        $commentManager = new \fletour\model\backend\CommentManagerBackEnd();
        $comments = $commentManager->getComments();

        require('view/backend/commentsViewAdmin.php');
    }

    public static function saveNewPost($blogPostId, $blogPostTitle, $textPost)
    {
        $postManager = new \fletour\model\backend\PostManagerBackEnd();
        $post = $postManager->saveNewPost($blogPostId, $blogPostTitle, $textPost);

        if ($blogPostId == 0) {
            $post = $postManager->lastPost();
            $blogPostId = $post['blogPostId'];
        }

        if ($_POST['bouton'] === 'quitter') {
            header('Location: listPosts');
        } elseif ($_POST['bouton'] === 'continuer') {
            header("Location: index.php?action=modifyPost&id=$blogPostId");
        }
    }

    public static function modifyPost($id)
    {
        $postManager = new \fletour\model\frontend\PostManager();
        $post = $postManager->getPost($id);

        require('view/backend/newPost.php');
    }

    public static function deletePost($id)
    {
        $postManager = new \fletour\model\backend\PostManagerBackEnd();
        $post = $postManager->deletePost($id);

        header("Location: index.php");
    }

    public static function unDeletePost($id)
    {
        $postManager = new \fletour\model\backend\PostManagerBackEnd();
        $post = $postManager->unDeletePost($id);

        require('view/backend/manageTrash.php');
    }

    public static function modifyPostStatus($id)
    {
        $postManager = new \fletour\model\backend\PostManagerBackEnd();
        $post = $postManager->modifyPostStatus($id);
        header("Location: index.php");
    }

    public static function updateBlogPostId($blogPostId, $newBlogPostId)
    {
        $newBlogPostId = intval($newBlogPostId);
        if (is_int($newBlogPostId)) {
            $postManager = new \fletour\model\backend\PostManagerBackEnd();
            $post = $postManager->updateBlogPostId($blogPostId, $newBlogPostId);

            $postManager = new \fletour\model\frontend\PostManager();
            $posts = $postManager->getPosts();
            require('view/backend/numberBlogPost.php');
        }
        else
        {
            throw new \Exception("Désolé, vous n'avez pas saisi un nombre entier");
        }
    }

    public static function updateIncrementingBlogPost() {
        $postManager = new \fletour\model\backend\PostManagerBackEnd();
        $post = $postManager->updateIncrementingBlogPost();

        throw new \Exception("Votre base de données a été modifié. Choisissez une nouvelle activité dans le menu");
    }

    public static function erasePost($id) {
        if (isset($id)) {
            $postManager = new \fletour\model\backend\PostManagerBackEnd();
            $post = $postManager->erasePost($id);
            header("Location: index.php?action=manageTrash");

        }
    }

    public static function commentsValidate($id)
    {
        $commentManager = new \fletour\model\backend\CommentManagerBackEnd();
        $comments = $commentManager->updatecommentReport($id);

        header('Location: commentsAdmin');
    }

    public static function commentsModify($id)
    {
        $commentManager = new \fletour\model\backend\CommentManagerBackEnd();
        $comments = $commentManager->getOneComment($id);

        if ($comments['answerId'] != 0) {
            require('view/backend/answerModify.php');
        } else {
            require('view/backend/commentsModify.php');
        }
    }

    public static function commentUpdate($id, $content)
    {
        $commentManager = new \fletour\model\backend\CommentManagerBackEnd();
        $comments = $commentManager->commentUpdateBdd($id, $content);

        header('Location: commentsAdmin');
    }

    public static function commentsDelete($id)
    {
        $commentManager = new \fletour\model\backend\CommentManagerBackEnd();
        $comments = $commentManager->commentDelete($id);

        header('Location: commentsAdmin');
    }

}