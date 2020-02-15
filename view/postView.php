<?php 
//session_start();

ob_start(); 

while ($data = $posts->fetch())
    {
         
    ?>
    <h2 class="titreChapitre text-info">Chapitre <?= $data['blogPostId']?> : <?= htmlspecialchars($data['blogPostTitle'])  ?></h2>
            <p>
                <?= $data['blogPostContents']  ?>
            </p> 
            <button class="btn btn-outline-info" data-toggle="modal" data-target="#modalCommentaire">laissez-un commentaire</button>
        
            <!-- Modal commentaire -->
            <div class="modal fade" id="modalCommentaire" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalCenterTitle">Quel est votre commentaire ?</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="index.php?action=addComment" method="POST">
                                <input type="hidden" name="commentBlogPostId" value="<?php echo $data['blogPostId']; ?>">
                                <!-- user is connected or no ?????-->
                                <?php
                                if (isset($_SESSION['userPseudo'])) {
                                    echo '<input type="hidden" name="userId" value="'. $_SESSION['userId'] .'">';

                                    echo '<input type="hidden" name="userPseudo" value="'. $_SESSION['userPseudo'] .'">';

                                    echo '<h5>Bonjour <strong>'. $_SESSION['userPseudo'] .'</strong>, merci de laisser un commentaire.</h5>';
                                }
                                else
                                {
                                    echo '<input type="hidden" name="userId" value="2">';
                                    echo '<div class="form-group">
                                    <label for="pseudoId">Pseudo</label>
                                    <input type="text" class="form-control border" id="pseudoId" aria-describedby="pseudoAide" name="commentAuthor" >
                                    <small id="pseudoIdAide" class="form-text text-muted alert alert-danger hidden">Merci de ne pas utiliser de balise</small>
                                </div>   ';
                                }



                                ?>
                                

                                
                                <div class="form-group">
                                    <label for="commentaire" >Votre commentaire</label>
                                    <textarea class="form-control" id="commentaire" rows="5" name="commentContents"></textarea>
                                    <small id="commentaireAide" class="form-text text-muted alert alert-danger hidden">Merci de ne pas utiliser de balise</small>
                                </div> 
                                <button type="submit" id="submitButton"class="btn btn-info" disabled>Envoyer</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- fin modal commentaire-->
    
        <?php
        while ($dataComment = $comments->fetch())
        {

            if ($dataComment['startingCommentId'] == 0) 
            {   ?>
                <div class="commentaire">
                    <div class="commentairePseudo text-light">
                        <h4>
                            <?php
                                if ($dataComment['userPseudo'] == "non_reconnu")
                                {
                                    echo htmlspecialchars($dataComment['commentAuthor']); 
                                }
                                else
                                {
                                    echo htmlspecialchars($dataComment['userPseudo']);  
                                }
                            ?>
                        </h4> 
                    
                        <form action="index.php?action=moderate&commentId=<?= $dataComment['commentId']; ?>&&id=<?= $data['blogPostId']; ?>" method="post" class="float-right">
                            <?php
                                switch ($dataComment['commentReport']) {
                                    case 1:
                                    echo "<button class=\"btn-warning form-control CommentaireButton\">Attente modération</button>";
                                    break;

                                    case 2:
                                        echo "<button class=\"btn btn-danger form-control CommentaireButton\">Signaler ce commentaire</button>";
                                        break;
                                                
                                    case 3:
                                    echo "<button class=\"btn-success form-control CommentaireButton\">Commentaire Validé</button>";
                                    break;
                                            
                                }
                            ?>
                        </form>
                    </div>
                    <div class="commentaireTexte">
                        <p><?= htmlspecialchars($dataComment['commentContents'])  ?></p>
                        <?php 
                            if ($dataComment['answerId'] !=0) 
                            {
                                echo "réponse de Jean Forteroche : ";
                                echo "<em>".$dataComment['answerContents']."</em>";
                            }
                        ?>
                    </div>
               </div>
               <?php
            }
       ?>
        
        
      <?php } 
       ?>

<?php
}
$posts->closeCursor();
$content = ob_get_clean(); 
require('template.php'); 

?>

