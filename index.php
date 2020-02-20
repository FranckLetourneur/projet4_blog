<?php
namespace fletour;
session_start();

require ('vendor/autoload.php');
\fletour\Autoloader::register(); 

try {
    if (isset($_GET['action'])) {
        if ($_GET['action'] === 'contact') {
            require('view/frontend/contact.php');
        }

        elseif ($_GET['action'] === 'author') {
            require('view/frontend/author.php');
        }

        elseif ($_GET['action'] === 'connexion') {
            require('view/frontend/connexionView.php');
        }

        elseif ($_GET['action'] === 'deconnexion') {
            controller\FrontEnd::deconnexion();
        }
        
        elseif ($_GET['action'] === 'listPosts') {//
            controller\FrontEnd::listPosts();
        }

        elseif ($_GET['action'] == 'post') {
            if (isset($_GET['id']) && $_GET['id'] > 0) {
                controller\FrontEnd::post();
            }
            else {
                throw new \Exception('Aucun identifiant de billet envoyé');
            }
        }

        elseif ($_GET['action'] == 'addComment') {
            if (!isset($_POST['startingCommentId'])) 
            {   
                $startingCommentId = 0;
            }
            else
            {
                $startingCommentId = $_POST['startingCommentId'];
            }

            controller\FrontEnd::addComment($_POST['userId'], $_POST['commentAuthor'], $_POST['commentBlogPostId'], $_POST['commentContents'], $startingCommentId);
        }

        elseif ($_GET['action'] == 'moderate')
        {
            if (isset($_GET['commentId']) && $_GET['commentId'] > 0) 
            {
                controller\FrontEnd::moderate($_GET['commentId']);
            }
        }

        elseif ($_GET['action'] === 'checkConnexion') {
            controller\FrontEnd::checkConnexion();
        }

        elseif ($_GET['action'] === 'userRegistration') {
            controller\FrontEnd::userRegistration();
        }

        elseif ($_GET['action'] === 'userCreate') {
            controller\FrontEnd::userCreate();
        }

        
        elseif (isset($_SESSION['userRole']) && $_SESSION['userRole'] == 0) {
            if ($_GET['action'] === 'newPost') {
                require('view/backend/newPost.php');
            }
            elseif ($_GET['action'] === 'saveNewPost'){
                controller\BackEnd::saveNewPost($_POST['blogPostId'],$_POST['blogPostTitle'],$_POST['textPost']);
            }
            elseif  ($_GET['action'] === 'modifyPost' && isset($_GET['id']) && $_GET['id'] != 0){
                controller\BackEnd::modifyPost($_GET['id']);
            }
            elseif ($_GET['action'] === 'deletePost' && isset($_GET['id']) && $_GET['id'] != 0) {
                controller\BackEnd::deletePost($_GET['id']);
            }
            elseif ($_GET['action'] === 'unDeletePost' && isset($_GET['id']) && $_GET['id'] != 0) {
                controller\BackEnd::unDeletePost($_GET['id']);
            }
            elseif ($_GET['action'] === 'modifyPostStatus' && isset ($_GET['id']) && $_GET['id'] != 0) {
                controller\BackEnd::modifyPostStatus($_GET['id']);
            }
            elseif ($_GET['action'] === 'updateBlogPostId') {
                controller\BackEnd::updateBlogPostId($_POST['blogPostId'], $_POST['newBlogPostId']);
            }
            elseif ($_GET['action'] === 'updateIncrementingBlogPost') {
                controller\BackEnd::updateIncrementingBlogPost();
            }
            elseif ($_GET['action'] === 'erasePost' && isset($_GET['id'])) {
                controller\BackEnd::erasePost($_GET['id']);
            }

            elseif ($_GET['action'] === 'listBlogPost') {
                controller\BackEnd::listBlogPost();
            }
            elseif ($_GET['action'] === 'commentsValidation' && isset($_GET['id'])) {
                controller\BackEnd::commentsValidate($_GET['id']);
            }
            elseif ($_GET['action'] === 'commentsModify' && isset($_GET['id'])) {
                controller\BackEnd::commentsModify($_GET['id']);
            }
            elseif ($_GET['action'] === 'commentsUpdate') {
                controller\BackEnd::commentUpdate($_POST['commentId'], $_POST['commentContents']);
            }
            elseif ($_GET['action'] === 'commentsDelete') {
                controller\BackEnd::commentsDelete($_GET['id']);
            }





            elseif ($_GET['action'] === 'numberBlogPost') {
                controller\BackEnd::numberBlogPost();
            }
            elseif ($_GET['action'] === 'manageTrash') {
                controller\BackEnd::manageTrash();
            }
            elseif ($_GET['action'] === 'commentsAdmin') {
                controller\BackEnd::commentsAdmin();
            }
            else {
                throw new \Exception("Soit je ne connais pass cette page, soit vous n'avez pas le droit d'y accéder. Désolé");
            }
        
        }
    
        else {
            throw new \Exception("erreur 404");    
        }    
    }
    else {
        controller\FrontEnd::listPosts();
    }

}
catch(\Exception $e) { 
    $errorMessage = $e->getMessage();
    require('view/frontend/errorView.php');

}