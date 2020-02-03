
<?php
require('controller/controller.php');

try {
    if (isset($_GET['action'])) {
        if ($_GET['action'] == 'listPosts') {
            Controller::listPosts();
        }
        elseif ($_GET['action'] == 'post') {
            if (isset($_GET['id']) && $_GET['id'] > 0) {
                Controller::post();
            }
            else {
                throw new Exception('Aucun identifiant de billet envoyé');
            }
        }
        elseif ($_GET['action'] == 'addComment') {
            Controller::addComment($_POST['id_user'], $_POST['author'], $_POST['id_blog_post'], $_POST['comment']);
        }
        elseif ($_GET['action'] == 'moderate')
        {
            if (isset($_GET['comment_id']) && $_GET['comment_id'] > 0) 
            {
                Controller::moderate($_GET['comment_id']);
            }
        }
    } 
    else {
        Controller::listPosts();
    }
}


catch(Exception $e) { 
    $errorMessage = $e->getMessage();
    require('view/errorView.php');
}
