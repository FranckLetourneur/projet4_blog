<?php 

ob_start(); 

    {
        ?>

        <form action="addComment" method="POST">
            <h5> Voici le message auquel vous souhaitez répondre</h5>
            <p><?= $comments['commentContents'] ?></p>
            <input type="hidden" name="startingCommentId" value="<?= $comments['commentId'] ?>">
            <input type="hidden" name="userId" value="<?= $_SESSION['userId'] ?>">
            <input type="hidden" name="commentAuthor" value="@&"> 
            <input type="hidden" name="commentBlogPostId" value="<?= $comments['commentBlogPostId'] ?>"> 
       

            <div class="form-group">
                <label for="commentaire" >Quel est votre réponse :</label>
                <textarea class="form-control" id="commentaire" rows="5" name="commentContents"><?= $comments['answerContents'] ?></textarea>
                <small id="commentaireAide" class="form-text text-muted alert alert-danger hidden">Merci de ne pas utiliser de balise</small>
            </div> 

            <button type="submit" id="submitButton"class="btn btn-info" disabled>Envoyer</button>
            </form>





        <?php
    }

$content = ob_get_clean(); 

require('view/frontend/template.php'); 

?>

