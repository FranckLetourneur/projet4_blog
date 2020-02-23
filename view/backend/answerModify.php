<?php 

ob_start(); 

    {
        ?>

        <form action="commentsUpdate" method="POST">
            <h5> Voici le message auquel vous souhaitez répondre</h5>
            <p><?= $comments->getCommentContents() ?></p>
            <input type="hidden" name="commentId" value="<?php if($comments->getAnswerId() !=NULL)
                                                            {echo $comments->getAnswerId();}  ?>">
       

            <div class="form-group">
                <label for="commentaire" >Quel est votre réponse :</label>
                <textarea class="form-control" id="commentaire" rows="5" name="commentContents"><?= $comments->getAnswerContents() ?></textarea>
                <small id="commentaireAide" class="form-text text-muted alert alert-danger hidden">Merci de ne pas utiliser de balise</small>
            </div> 

            <button type="submit" id="submitButton"class="btn btn-info" disabled>Envoyer</button>
            </form>





        <?php
    }

$content = ob_get_clean(); 

require('view/frontend/template.php'); 

?>

