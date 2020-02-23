<?php
namespace fletour;
session_start();

require ('vendor/autoload.php');
\fletour\Autoloader::register(); 

$db = vendor\DBFactory::getMysqlConnexionWithPDO();
$controllerFrontEnd = new controller\FrontEnd($db);
$controllerBackEnd = new controller\Backend($db);
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
            $controllerFrontEnd->deconnexion();
        }
        elseif ($_GET['action'] === 'listPosts') {
            if (isset($_GET['page']) && $_GET['page'] > 0) {
                $controllerFrontEnd->listPosts($_GET['page']);
            }
            elseif ($_GET['list'] === 'list') {
                $controllerFrontEnd->listPosts(1);
            }
            else{
                header ('Location: index.php?action=listPosts&page=1');
            }
        }
        elseif ($_GET['action'] == 'post') {
            if (isset($_GET['id']) && $_GET['id'] > 0) {
                $controllerFrontEnd->post($_GET['id']);
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
            $controllerFrontEnd->addComment($_POST['userId'], $_POST['commentAuthor'], $_POST['commentBlogPostId'], $_POST['commentContents'], $startingCommentId);
        }
        elseif ($_GET['action'] == 'moderate')
        {
            if (isset($_GET['commentId']) && $_GET['commentId'] > 0) 
            {
                $controllerFrontEnd->moderate($_GET['commentId']);
            }
        }
        elseif ($_GET['action'] === 'checkConnexion') {
            $controllerFrontEnd->checkConnexion();
        }
        elseif ($_GET['action'] === 'userRegistration') {
            $controllerFrontEnd->userRegistration();
        }
        elseif ($_GET['action'] === 'userCreate') {
            $controllerFrontEnd->userCreate();
        }
        elseif ($_GET['action'] === 'confidential'){
            require('view/frontend/confidential.php');
        }


        elseif (isset($_SESSION['userRole']) && $_SESSION['userRole'] == 0) {
            if ($_GET['action'] === 'newPost') {
                require('view/backend/newPost.php');
            }
            elseif ($_GET['action'] === 'saveNewPost'){
                $controllerBackEnd->saveNewPost($_POST['blogPostId'],$_POST['blogPostTitle'],$_POST['textPost']);
            }
            elseif  ($_GET['action'] === 'modifyPost' && isset($_GET['id']) && $_GET['id'] != 0){
                $controllerBackEnd->modifyPost($_GET['id']);
            }
            elseif ($_GET['action'] === 'deletePost' && isset($_GET['id']) && $_GET['id'] != 0) {
                $controllerBackEnd->deletePost($_GET['id']);
            }
            elseif ($_GET['action'] === 'unDeletePost' && isset($_GET['id']) && $_GET['id'] != 0) {
                $controllerBackEnd->unDeletePost($_GET['id']);
            }
            elseif ($_GET['action'] === 'modifyPostStatus' && isset ($_GET['id']) && $_GET['id'] != 0) {
                $controllerBackEnd->modifyPostStatus($_GET['id']);
            }
            elseif ($_GET['action'] === 'updateBlogPostId') {
                $controllerBackEnd->updateBlogPostId($_POST['blogPostId'], $_POST['newBlogPostId']);
            }
            elseif ($_GET['action'] === 'updateIncrementingBlogPost') {
                $controllerBackEnd->updateIncrementingBlogPost();
            }
            elseif ($_GET['action'] === 'erasePost' && isset($_GET['id'])) {
                $controllerBackEnd->erasePost($_GET['id']);
            }
            elseif ($_GET['action'] === 'listBlogPost') {
                $controllerBackEnd->listBlogPost();
            }
            elseif ($_GET['action'] === 'commentsValidation' && isset($_GET['id'])) {
                $controllerBackEnd->commentsValidate($_GET['id']);
            }
            elseif ($_GET['action'] === 'commentsModify' && isset($_GET['id'])) {
                $controllerBackEnd->commentsModify($_GET['id']);
            }
            elseif ($_GET['action'] === 'commentsUpdate') {
                $controllerBackEnd->commentUpdate($_POST['commentId'], $_POST['commentContents']);
            }
            elseif ($_GET['action'] === 'commentsDelete') {
                $controllerBackEnd->commentsDelete($_GET['id']);
            }
            elseif ($_GET['action'] === 'userAdmin') {
                $controllerBackEnd->userAdmin();
            }
            elseif ($_GET['action'] === 'eraseUser' && isset($_GET['id'])) {
                $controllerBackEnd->eraseUser($_GET['id']);
            }
            elseif ($_GET['action'] === 'numberBlogPost') {
                $controllerBackEnd->numberBlogPost();
            }
            elseif ($_GET['action'] === 'manageTrash') {
                $controllerBackEnd->manageTrash();
            }
            elseif ($_GET['action'] === 'commentsAdmin') {
                $controllerBackEnd->commentsAdmin();
            }





            
            else {
                throw new \Exception("Soit je ne connais pas cette page, soit vous n'avez pas le droit d'y accéder. Désolé");
            }

        }
        else {
            throw new \Exception("Soit je ne connais pas cette page, soit vous n'avez pas le droit d'y accéder. Désolé");
        }
    }
    
    else {
        $controllerFrontEnd->listPosts(1);        
    }
   

}
catch(\Exception $e) { 
    $errorMessage = $e->getMessage();
    require('view/frontend/errorView.php');

}