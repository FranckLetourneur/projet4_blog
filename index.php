<?php
namespace fletour;
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
            controller\Controller::addComment($_POST['id_user'], $_POST['author'], $_POST['id_blog_post'], $_POST['comment']);
        }


        elseif ($_GET['action'] == 'moderate')
        {
            if (isset($_GET['comment_id']) && $_GET['comment_id'] > 0) 
            {
                controller\Controller::moderate($_GET['comment_id']);
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
        //    var_dump $_POST;
            controller\Controller::userCreate();
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
