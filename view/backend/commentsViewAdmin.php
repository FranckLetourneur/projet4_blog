<?php 

ob_start(); 
$chap = 1;
echo "<h2>Chap. ". $chap ."</h2>";
foreach($comments as $data)
    {
        if ($data->getCommentBlogPostId() != $chap && $data->getStartingCommentId() == 0)
        {
            echo "<h2>Chap. ". $data->getCommentBlogPostId() ."</h2>";
            $chap++;
        }

        switch ($data->getCommentReport()) {
            case 'reported':
                $fond = "bg-danger";
                break;
            case 'waiting':
                $fond = "bg-warning";
                break;
            default:
                $fond = "";
            break;
            }
        
        
        if ($data->getStartingCommentId() == 0) 
        {
        ?>
        <div class="d-flex flex-row mb-4 border border-secondary <?= $fond;?>">
            <div class="d-flex flex-column col-11 sansPadding ">
                <div class="d-flex flex-row bg-secondary text-white">
                    <div class="commentsNews col"><?php if ($data->getCommentsUserId() != 2){ echo $data->getUserPseudo();} ;?></div>
                    <div class="commentsNews col"><?= $data->getCommentAuthor() ;?></div>
                    <div class="commentsNews col"><?= $data->getcommentDateFr() ;?></div>
                </div>
                <div>
                    <?php

                    echo '<p class="commentaireTexte">'. htmlspecialchars($data->getCommentContents()) .'</p>'; 
                    
                    if ($data->getAnswerId() !=0) 
                        {
                            echo '<hr><p class="commentaireTexte">Votre réponse : <br>';
                            echo '<em>'. $data->getAnswerContents() .'</em></p>';
                        }
                    ?>
                    

                </div>
            </div>
            <div class="p-2 d-flex col-1 text-center pictoCommentsAdmin">
                <?php $message="'Etes-vous sûr de vouloir supprimer cette entrée?'"; ?>
                <a href="index.php?action=commentsValidation&id=<?= $data->getCommentId() ?>" class="text-dark" title="Pour valider le commentaire"><i class="p-2 fas fa-check-square fa-lg"></i></a>
                <a href="index.php?action=commentsModify&id=<?= $data->getCommentId() ?>" class="text-dark" title="Pour répondre au commentaire ou corriger votre réponse"><i class="p-2 fas fa-pencil-alt fa-lg "></i></a>
                <a href="index.php?action=commentsDelete&id=<?= $data->getCommentId() ?>" onclick=" return confirm('Etes-vous sûr de vouloir supprimer ce commentaire ? ');" class="text-dark" title="Pour supprimer le commentaire"><i class="p-2 fas fa-trash-alt fa-lg"></i></a>
            </div>    
        </div>
       
        <?php
        }
    }

$content = ob_get_clean(); 
require('view/frontend/template.php'); 

?>

