<?php 

ob_start(); 
$chap = 1;
echo "<h2>Chap. ". $chap ."</h2>";
while ($data = $comments->fetch())
    {
        if ($data['commentBlogPostId'] != $chap && $data['startingCommentId'] == 0)
        {
            echo "<h2>Chap. ". $data['commentBlogPostId'] ."</h2>";
            $chap++;
        }

        switch ($data['commentReport']) {
            case 1:
                $fond = "bg-danger";
                break;
            case 2:
                $fond = "bg-warning";
                break;
            default:
                $fond = "";
            break;
            }
        
        
        if ($data['startingCommentId'] == 0) 
        {
        ?>

       
        <div class="d-flex flex-row mb-4 border border-secondary <?= $fond;?>">
            <div class="d-flex flex-column col-11 sansPadding ">
                <div class="d-flex flex-row bg-secondary text-white">
                    <div class="commentsNews col"><?php if ($data['commentsUserId'] != 2){ echo $data['userPseudo'];} ;?></div>
                    <div class="commentsNews col"><?= $data['commentAuthor'] ;?></div>
                    <div class="commentsNews col"><?= $data['commentDate_fr'] ;?></div>
                </div>
                <div>
                    <?php

                    echo '<p class="commentaireTexte">'. htmlspecialchars($data['commentContents']) .'</p>'; 
                    
                    if ($data['answerId'] !=0) 
                        {
                            echo '<hr><p class="commentaireTexte">Votre réponse : <br>';
                            echo '<em>'. $data['answerContents'] .'</em></p>';
                        }
                    ?>
                    

                </div>
            </div>
            <div class="p-2 d-flex col-1 text-center pictoCommentsAdmin">
                <a href="index.php?action=commentsValidation&id=<?= $data['commentId'] ?>" class="text-dark" title="Pour valider le commentaire"><i class="p-2 fas fa-check-square fa-lg"></i></a>
                <a href="index.php?action=commentsModify&id=<?= $data['commentId'] ?>" class="text-dark" title="Pour répondre au commentaire ou corriger votre réponse"><i class="p-2 fas fa-pencil-alt fa-lg "></i></a>
                <a href="index.php?action=commentsDelete&id=<?= $data['commentId'] ?>" class="text-dark" title="Pour supprimer le commentaire"><i class="p-2 fas fa-trash-alt fa-lg"></i></a>
            </div>    
        </div>
       
        <?php
        }
    }
$comments->closeCursor();

$content = ob_get_clean(); 
require('view/template.php'); 

?>

