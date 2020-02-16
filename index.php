<?php
namespace fletour;
session_start();

require 'vendor/autoload.php'; 
\fletour\Autoloader::register(); 

//require('controller/controller.php');

try {
    if (isset($_GET['action'])) {
        if ($_GET['action'] == 'listPosts') {
            controller\Controller::listPosts();
        }


        elseif ($_GET['action'] == 'post') {
            if (isset($_GET['id']) && $_GET['id'] > 0) {
                controller\Controller::post();
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
            controller\Controller::addComment($_POST['userId'], $_POST['commentAuthor'], $_POST['commentBlogPostId'], $_POST['commentContents'], $startingCommentId);
        }


        elseif ($_GET['action'] == 'moderate')
        {
            if (isset($_GET['commentId']) && $_GET['commentId'] > 0) 
            {
                controller\Controller::moderate($_GET['commentId']);
            }
        }


        elseif ($_GET['action'] === 'connexion') {
            controller\Controller::connexion();
        }


        elseif ($_GET['action'] === 'checkConnexion') {
            controller\Controller::checkConnexion();
        }

        elseif ($_GET['action'] === 'userRegistration') {
            controller\Controller::userRegistration();
        }

        elseif ($_GET['action'] === 'userCreate') {
            controller\Controller::userCreate();
        }

        
        elseif ($_GET['action'] === 'deconnexion') {
            controller\Controller::deconnexion();
        }

        elseif (isset($_SESSION['userRole']) && $_SESSION['userRole'] == 0) {
            if ($_GET['action'] === 'commentsAdmin') {
                controller\ControllerBack::commentsAdmin();
            }

            elseif ($_GET['action'] === 'commentsValidation' && isset($_GET['id'])) {
                controller\ControllerBack::commentsValidate($_GET['id']);
            }

            elseif ($_GET['action'] === 'commentsModify' && isset($_GET['id'])) {
                controller\ControllerBack::commentsModify($_GET['id']);
            }

            elseif ($_GET['action'] === 'commentsUpdate') {
                controller\ControllerBack::commentUpdate($_POST['commentId'], $_POST['commentContents']);
            }

            elseif ($_GET['action'] === 'commentsDelete') {
                controller\ControllerBack::commentsDelete($_GET['id']);
            }

            elseif ($_GET['action'] === 'newPost') {
                require('view/back/newPost.php');
            }

            elseif ($_GET['action'] === 'saveNewPost'){
                controller\ControllerBack::saveNewPost($_POST['blogPostId'],$_POST['blogPostTitle'],$_POST['textPost']);
            }

            elseif  ($_GET['action'] === 'modifyPost' && isset($_GET['id']) && $_GET['id'] != 0){
                controller\ControllerBack::modifyPost($_GET['id']);
            }

            elseif ($_GET['action'] === 'deletePost' && isset($_GET['id']) && $_GET['id'] != 0) {
                controller\ControllerBack::deletePost($_GET['id']);
            }

            elseif ($_GET['action'] === 'unDeletePost' && isset($_GET['id']) && $_GET['id'] != 0) {
                controller\ControllerBack::unDeletePost($_GET['id']);
            }

            elseif ($_GET['action'] === 'modifyPostStatus' && isset ($_GET['id']) && $_GET['id'] != 0) {
                controller\ControllerBack::modifyPostStatus($_GET['id']);
            }

            elseif ($_GET['action'] === 'listBlogPost') {
                controller\ControllerBack::listBlogPost();
            }

            elseif ($_GET['action'] === 'manageTrash') {
                controller\ControllerBack::manageTrash();
            }

            elseif ($_GET['action'] === 'numberBlogPost') {
                controller\ControllerBack::numberBlogPost();
            }

            elseif ($_GET['action'] === 'updateBlogPostId') {
                controller\ControllerBack::updateBlogPostId($_POST['blogPostId'], $_POST['newBlogPostId']);
            }

            elseif ($_GET['action'] === 'updateIncrementingBlogPost') {
                controller\ControllerBack::updateIncrementingBlogPost();
            }

            elseif ($_GET['action'] === 'erasePost' && isset($_GET['id'])) {
                controller\ControllerBack::erasePost($_GET['id']);
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
        controller\Controller::listPosts();
    }
}


catch(\Exception $e) { 
    $errorMessage = $e->getMessage();
    require('view/errorView.php');
}
