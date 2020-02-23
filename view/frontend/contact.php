<?php 

ob_start(); 
?>        
    <h2 class="text-center">Formulaire de contact</h2>
    <div class="row justify-content-center">
        <div class="col-xl-6 col-lg-8 col-md-12">
            <form action="index.php?action=sendMail" method="POST">
                <div class="form-group">
                    <label for="lastNameId">Nom :</label>
                    <input type="text" class="form-control border" id="lastNameId" aria-describedby="lastNameIdAide" name="lastName">
                    <small id="lastNameIdAide" class="form-text text-muted alert alert-danger hidden">Merci de ne pas utiliser de balise</small>
                </div>

                <div class="form-group">
                    <label for="firstNameId">Prénom :</label>
                    <input type="text" class="form-control border" id="firstNameId" aria-describedby="firstNameIdAide" name="firstName">
                    <small id="firstNameIdAide" class="form-text text-muted alert alert-danger hidden">Merci de ne pas utiliser de balise</small>
                </div>   
                
                <div class="form-group">
                    <label for="mailId">Adresse mail :</label>
                    <input type="email" class="form-control border" id="mailId" aria-describedby="mailIdAide" name="mail">
                    <small id="mailIdAide" class="form-text text-muted alert alert-danger hidden">Merci de ne pas utiliser de balise</small>
                </div>   

                <div class="form-group">
                    <label for="subject">Sujet du message :</label>
                    <input type="text" class="form-control border" id="subject" aria-describedby="subjectAide" name="subject">
                    <small id="subjectAide" class="form-text text-muted alert alert-danger hidden">Merci de ne pas utiliser de balise</small>
                </div>
                
                <div class="form-group">
                    <label for="commentaire" >Votre message :</label>
                    <textarea class="form-control" id="commentaire" rows="5" name="commentaire"></textarea>
                    <small id="commentaireAide" class="form-text text-muted alert alert-danger hidden">Merci de ne pas utiliser de balise</small>
                </div> 

                <button type="submit" id="submitButton"class="btn btn-info" disabled>Envoyer le mail</button>
            </form>
        </div>
    </div>
                    
<?php
$content = ob_get_clean(); 
require('template.php'); 

?>

