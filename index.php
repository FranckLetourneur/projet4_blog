<?php
namespace fletour;
session_start();

require ('vendor/autoload.php');
\fletour\Autoloader::register(); 

//require ('vendor/DBFactory.php');
$db = vendor\DBFactory::getMysqlConnexionWithPDO();
$controllerFrontEnd = new controller\FrontEnd($db);

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
            else{
                header ('Location: index.php?action=listPosts&page=1');
            }
        }






        elseif (isset($_SESSION['userRole']) && $_SESSION['userRole'] == 0) {

        }
        else {
            throw new \Exception("Soit je ne connais pass cette page, soit vous n'avez pas le droit d'y accéder. Désolé");
        }
    }
    else {
        throw new \Exception("erreur 404");    
    }
   

}
catch(\Exception $e) { 
    $errorMessage = $e->getMessage();
    require('view/frontend/errorView.php');

}