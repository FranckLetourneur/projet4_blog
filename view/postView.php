<?php 

ob_start(); 
while ($data = $posts->fetch())
    {	
    ?>
    <h2 class="titreChapitre text-info">Chapitre <?= $data['id_post']?> : <?= htmlspecialchars($data['title_post'])  ?></h2>
            <p>
                <?= htmlspecialchars($data['contents_post'])  ?>
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
                                <input type="hidden" name="id_blog_post" value="<?php echo $data['id_post']; ?>">
                                <!-- user is connected or no ?????-->
                                <input type="hidden" name="id_user" value="2">

                                <div class="form-group">
                                    <label for="pseudoId">Pseudo</label>
                                    <input type="text" class="form-control border" id="pseudoId" aria-describedby="pseudoAide" name="author">
                                    <small id="pseudoAide" class="form-text text-muted alert alert-danger hidden">Merci de ne pas utiliser de balise</small>
                                </div>   
                                <div class="form-group">
                                    <label for="commentaire" >Votre commentaire</label>
                                    <textarea class="form-control" id="commentaire" rows="5" name="comment"></textarea>
                                    <small id="commentaireAide" class="form-text text-muted alert alert-danger hidden">Merci de ne pas utiliser de balise</small>
                                </div> 
                                <button type="submit" id="submitComment"class="btn btn-info">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- fin modal commentaire-->
    
       <?php
       while ($dataComment = $comments->fetch())
       {
       ?>
        <div class="commentaire">
            <div class="commentairePseudo text-light">
                <h4><?php
                    if ($dataComment['pseudo_user'] == "non_reconnu")
                    {
                        echo htmlspecialchars($dataComment['author']); 
                    }
                    else
                    {
                        echo htmlspecialchars($dataComment['pseudo_user']);  
                    }
                    ?></h4> 
                   <form action="index.php?action=moderate&comment_id=<?= $dataComment['comment_id']; ?>&&id=<?= $data['id_post']; ?>" method="post" class="float-right">
                        
                        <?php
                            switch ($dataComment['report']) {
                                case '0':
                                    echo "<button class=\"btn btn-danger form-control CommentaireButton\">Signaler ce commentaire</button>";
                                    break;
                                case '1':
                                    echo "<button class=\"btn-warning form-control CommentaireButton\">Attente modération</button>";
                                    break;
                                    
                                case '2':
                                    echo "<button class=\"btn-success form-control CommentaireButton\">Commentaire Validé</button>";
                                    break;
                                    
                            }
                        ?>
                        
                   </form>
                </div>
                <div class="commentaireTexte">
                    <p><?= htmlspecialchars($dataComment['contents_comment'])  ?></p>
                </div>

            </div>
        
      <?php } 
       ?>

<?php
}
$posts->closeCursor();
$content = ob_get_clean(); 
require('template.php'); 

?>

