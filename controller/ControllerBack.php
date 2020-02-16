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

        if ($comments['answerId'] != 0) {
            require('view/back/answerModify.php');
        } else {
            require('view/back/commentsModify.php');
        }
    }

    public static function commentUpdate($id, $content)
    {
        $commentManager = new \fletour\model\CommentManagerAdmin();
        $comments = $commentManager->commentUpdateBdd($id, $content);

        header('Location: index.php?action=commentsAdmin');
    }

    public static function commentsDelete($id)
    {
        $commentManager = new \fletour\model\CommentManagerAdmin();
        $comments = $commentManager->commentDelete($id);

        header('Location: index.php?action=commentsAdmin');
    }

    public static function saveNewPost($blogPostId, $blogPostTitle, $textPost)
    {
        $postManager = new \fletour\model\PostManagerAdmin();
        $post = $postManager->saveNewPost($blogPostId, $blogPostTitle, $textPost);

        if ($blogPostId == 0) {
            $post = $postManager->lastPost();
            $blogPostId = $post['blogPostId'];
        }

        if ($_POST['bouton'] === 'quitter') {
            header('Location: index.php?action=listPosts');
        } elseif ($_POST['bouton'] === 'continuer') {
            header("Location: index.php?action=modifyPost&id=$blogPostId");
        }
    }

    public static function modifyPost($id)
    {
        $postManager = new \fletour\model\PostManager();
        $post = $postManager->getPost($id);

        require('view/back/newPost.php');
    }


    public static function deletePost($id)
    {
        $postManager = new \fletour\model\PostManagerAdmin();
        $post = $postManager->deletePost($id);

        header("Location: index.php");
    }

    public static function unDeletePost($id)
    {
        $postManager = new \fletour\model\PostManagerAdmin();
        $post = $postManager->unDeletePost($id);

        require('view/back/manageTrash.php');
    }

    public static function modifyPostStatus($id)
    {
        $postManager = new \fletour\model\PostManagerAdmin();
        $post = $postManager->modifyPostStatus($id);
        header("Location: index.php");
    }

    public static function listBlogPost()
    {
        $postManager = new \fletour\model\PostManager();
        $posts = $postManager->getPosts();
        require('view/back/listBlogPost.php');
    }

    public static function manageTrash()
    {
        $postManager = new \fletour\model\PostManager();
        $posts = $postManager->getPosts();
        require('view/back/manageTrash.php');
    }

    public static function numberBlogPost()
    {
        $postManager = new \fletour\model\PostManager();
        $posts = $postManager->getPosts();
        require('view/back/numberBlogPost.php');
    }

    public static function updateBlogPostId($blogPostId, $newBlogPostId)
    {
        $newBlogPostId = intval($newBlogPostId);
        if (is_int($newBlogPostId)) {
            $postManager = new \fletour\model\PostManagerAdmin();
            $post = $postManager->updateBlogPostId($blogPostId, $newBlogPostId);

            $postManager = new \fletour\model\PostManager();
            $posts = $postManager->getPosts();
            require('view/back/numberBlogPost.php');
        }
        else
        {
            throw new \Exception("Désolé, vous n'avez pas saisi un nombre entier");
        }
    }

    public static function updateIncrementingBlogPost() {
        $postManager = new \fletour\model\PostManagerAdmin();
        $post = $postManager->updateIncrementingBlogPost();

        throw new \Exception("Votre base de données a été modifié. Choisissez une nouvelle activité dans le menu");
    }

    public static function erasePost($id) {
        if (isset($id)) {
            $postManager = new \fletour\model\PostManagerAdmin();
            $post = $postManager->erasePost($id);
            header("Location: index.php?action=manageTrash");

        }
    }
}
