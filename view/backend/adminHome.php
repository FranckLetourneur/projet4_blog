<?php

ob_start();
?>
<h2>Salut Jean, comment ça va ?</h2>
<h4>Que puis-je vous proposer aujourd'hui ?</h4>

<?php
foreach($posts as $data) {
    if ($data->getBlogPostStatus() == 'inProgress') 
    {
        echo "<h5>Continuer de travailler sur un chapitre commencé ?</h5>";
    break;
    }
}

foreach($posts as $data) {
    if ($data->getBlogPostStatus() == 'inProgress') 
    {   
        $tricolore = 'Red';
    ?>
    
    <div class="p-2 m-2 rounded bg-info d-flex justify-content-between ">
        <div class="h5">
            <?= $data->getBlogPostId() ?> • <?= $data->getBlogPostTitle() ?>
        </div>
        <div class="text-center">
            <a href="index.php?action=modifyPost&id=<?= $data->getBlogPostId() ?>" class="text-dark" title="Pour corriger ce chapitre"><i class="p-2 fas fa-pencil-alt fa-lg "></i></a>
            <a href="index.php?action=modifyPostStatus&id=<?= $data->getBlogPostId() ?>" title="Pour ouvrir ce chapitre à la lecture">
                <img src="public/image/tricolor<?= $tricolore ?>.png" alt="Feux tricolores indiquant le status de l'article">
            </a>
            <a href="index.php?action=deletePost&id=<?= $data->getBlogPostId() ?>" class="text-dark" onclick=" return confirm('Etes-vous sûr de vouloir supprimer ce chapitre ? ');" title="Pour supprimer ce chapitre"><i class="p-2 fas fa-trash-alt fa-lg"></i></a>
        </div>
    </div>
    <?php
    }
}

?>


<?php
$countDanger = 0;
foreach ($comments as $dataComment){
    if ($dataComment->getCommentReport() == 'reported'  && $dataComment->getStartingCommentId() == 0) 
    {
        $countDanger++;
        if ($countDanger == 1) {echo"<h5>Il y a de nouveaux commentaires signalés :</h5>";}
        ?>
        <div class="m-2 rounded border border-danger d-flex justify-content-between">
            <div class="d-flex flex-column flex-grow-1 sansPadding">
                <div class="d-flex flex-row bg-danger text-white justify-content-between">
                    <div class="commentsNews flex-fill">Chap. <?= $dataComment->getCommentBlogPostId(); ?></div>
                    <div class="commentsNews flex-fill"><?php if ($dataComment->getCommentsUserId() != 2) {
                                                        echo $dataComment->getUserPseudo();
                                                    }; ?></div>
                    <div class="commentsNews flex-fill"><?= $dataComment->getCommentAuthor(); ?></div>
                    <div class="commentsNews flex-fill"><?= $dataComment->getcommentDateFr(); ?></div>
                </div>
                
                <div>
                <?php
                    echo '<p class="commentaireTexte">' . htmlspecialchars($dataComment->getCommentContents()) . '</p>';
                    if ($dataComment->getAnswerId() != 0) {
                        echo '<hr><p class="commentaireTexte">Votre réponse : <br>';
                        echo '<em>' . $dataComment->getAnswerContents() . '</em></p>';
                    }
                ?>
                </div>
            </div>
            <div class="p-2 text-center pictoCommentsAdmin">
                <a href="index.php?action=commentsValidation&id=<?= $dataComment->getCommentId() ?>" class="text-dark" title="Pour valider le commentaire"><i class="p-2 fas fa-check-square fa-lg"></i></a>
                <a href="index.php?action=commentsModify&id=<?= $dataComment->getCommentId() ?>" class="text-dark" title="Pour répondre au commentaire ou corriger votre réponse"><i class="p-2 fas fa-pencil-alt fa-lg "></i></a>
                <a href="index.php?action=commentsDelete&id=<?= $dataComment->getCommentId() ?>" class="text-dark" title="Pour supprimer le commentaire"><i class="p-2 fas fa-trash-alt fa-lg"></i></a>
            </div>
        </div>
    <?php
    }
    unset($dataComment);
}
?>
<?php
$countWarning = 0;
foreach ($comments as $dataComment)
{
    if ($dataComment->getCommentReport() == 'waiting' && $dataComment->getStartingCommentId() == 0) 
    {
        $countWarning++;
        if ($countWarning == 1) {echo"<h5>Il y a de nouveaux commentaires que vous n'avez pas validé :</h5>";}
        ?>
        <div class="m-2 rounded border border-warning d-flex justify-content-between">
            <div class="d-flex flex-column flex-grow-1 sansPadding">
                <div class="d-flex flex-row bg-warning text-white justify-content-between">
                    <div class="commentsNews flex-fill">Chap. <?= $dataComment->getCommentBlogPostId(); ?></div>
                    <div class="commentsNews flex-fill"><?php if ($dataComment->getCommentsUserId() != 2) {
                                                        echo $dataComment->getUserPseudo();
                                                    }; ?></div>
                    <div class="commentsNews flex-fill"><?= $dataComment->getCommentAuthor(); ?></div>
                    <div class="commentsNews flex-fill"><?= $dataComment->getcommentDateFr(); ?></div>
                </div>
                
                <div>
                <?php
                    echo '<p class="commentaireTexte">' . htmlspecialchars($dataComment->getCommentContents()) . '</p>';
                    if ($dataComment->getAnswerId() != 0) {
                        echo '<hr><p class="commentaireTexte">Votre réponse : <br>';
                        echo '<em>' . $dataComment->getAnswerContents() . '</em></p>';
                    }
                ?>
                </div>
            </div>
            <div class="p-2 text-center pictoCommentsAdmin">
                <a href="index.php?action=commentsValidation&id=<?= $dataComment->getCommentId() ?>" class="text-dark" title="Pour valider le commentaire"><i class="p-2 fas fa-check-square fa-lg"></i></a>
                <a href="index.php?action=commentsModify&id=<?= $dataComment->getCommentId() ?>" class="text-dark" title="Pour répondre au commentaire ou corriger votre réponse"><i class="p-2 fas fa-pencil-alt fa-lg "></i></a>
                <a href="index.php?action=commentsDelete&id=<?= $dataComment->getCommentId() ?>" class="text-dark" title="Pour supprimer le commentaire"><i class="p-2 fas fa-trash-alt fa-lg"></i></a>
            </div>
        </div>

        
    <?php
    }
    unset($dataComment);
}


$content = ob_get_clean();
require('view/frontend/template.php');

?>