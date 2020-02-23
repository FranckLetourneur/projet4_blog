<?php 
ob_start(); 
?>        
    <h2 class="text-center">Formulaire d'inscription</h2>
    <div class="row justify-content-center">
        <div class="col-xl-4 col-lg-6 col-md-9 col-sm-12">
            <form action="userCreate" method="POST">
                <div class="form-group">
                    <label for="pseudoId">Pseudo</label>
                    <input type="text" class="form-control border" id="pseudoId" aria-describedby="pseudoAide" name="userName">
                    <small id="pseudoIdAide" class="form-text text-muted alert alert-danger hidden">Merci de ne pas utiliser de balise</small>
                </div>   
                <div class="form-group">
                    <label for="pseudoId">Mot de Passe</label>
                    <input type="password" class="form-control border" id="mdp" aria-describedby="mdpAide" name="userMdp">
                    <small id="mdpAide" class="form-text text-muted alert alert-danger hidden">Merci de ne pas utiliser de balise</small>
               </div> 
               <div class="form-group">
                    <label for="mailId">Adresse mail</label>
                    <input type="email" class="form-control border" id="mail" aria-describedby="mailAide" name="userMail">
                    <small id="mailAide" class="form-text text-muted alert alert-danger hidden">Merci de ne pas utiliser de balise</small>
               </div>                          
                <button type="submit" id="submitButton"class="btn btn-info" disabled>Enregistrer</button>
            </form>
        </div>
    </div>
                    
<?php
$content = ob_get_clean(); 
require('template.php'); 

?>

