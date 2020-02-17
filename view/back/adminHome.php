<?php

ob_start();
?>
<h2>Salut Jean, comment ça va ?</h2>
<h4>Que puis-je vous proposer aujourd'hui ?</h4>
<h5>Continuer sur un chapitre commencé ?</h5>

<?php

while ($data = $posts->fetch()) {
    if ($data['blogPostStatus'] == 'inProgress') {
        $tricolore = 'Red';

?>
        <div class="p-2 m-2 rounded bg-info d-flex justify-content-between ">
            <div class="">
                <?= $data['blogPostId'] ?> • <?= $data['blogPostTitle'] ?><br>
                <?= substr($data['blogPostContents'], 0, 100) ?>
            </div>
            <div class="text-center">
                <a href="index.php?action=modifyPost&id=<?= $data['blogPostId'] ?>" class="text-dark" title="Pour corriger ce chapitre"><i class="p-2 fas fa-pencil-alt fa-lg "></i></a>
                <a href="index.php?action=modifyPostStatus&id=<?= $data['blogPostId'] ?>" title="Pour ouvrir ce chapitre à la lecture">
                    <img src="public/image/tricolor<?= $tricolore ?>.png" alt="Feux tricolores indiquant le status de l'article">
                </a>

                <a href="index.php?action=deletePost&id=<?= $data['blogPostId'] ?>" class="text-dark" title="Pour supprimer ce chapitre"><i class="p-2 fas fa-trash-alt fa-lg"></i></a>

            </div>

        </div>
<?php
    }
}
$result = $comments->fetchAll();

?>


<?php
$countDanger = 0;
foreach ($result as $dataComment){

    if ($dataComment['commentReport'] == 'reported'  && $dataComment['startingCommentId'] == 0) {
        $countDanger++;
        if ($countDanger == 1) {echo"<h5>Il y a de nouveaux commentaires signalés :</h5>";}
?>
        <div class="d-flex flex-row mb-4 border border-danger">
            <div class="d-flex flex-column col-11 sansPadding ">
                <div class="d-flex flex-row bg-danger text-white">
                    <div class="commentsNews col">Chap. <?= $dataComment['commentBlogPostId']; ?></div>
                    <div class="commentsNews col"><?php if ($dataComment['commentsUserId'] != 2) {
                                                        echo $dataComment['userPseudo'];
                                                    }; ?></div>
                    <div class="commentsNews col"><?= $dataComment['commentAuthor']; ?></div>
                    <div class="commentsNews col"><?= $dataComment['commentDate_fr']; ?></div>
                </div>
                <div>
                    <?php

                    echo '<p class="commentaireTexte">' . htmlspecialchars($dataComment['commentContents']) . '</p>';

                    if ($data['answerId'] != 0) {
                        echo '<hr><p class="commentaireTexte">Votre réponse : <br>';
                        echo '<em>' . $dataComment['answerContents'] . '</em></p>';
                    }
                    ?>


                </div>
            </div>
            <div class="p-2 d-flex col-1 text-center pictoCommentsAdmin">
                <a href="index.php?action=commentsValidation&id=<?= $dataComment['commentId'] ?>" class="text-dark" title="Pour valider le commentaire"><i class="p-2 fas fa-check-square fa-lg"></i></a>
                <a href="index.php?action=commentsModify&id=<?= $dataComment['commentId'] ?>" class="text-dark" title="Pour répondre au commentaire ou corriger votre réponse"><i class="p-2 fas fa-pencil-alt fa-lg "></i></a>
                <a href="index.php?action=commentsDelete&id=<?= $dataComment['commentId'] ?>" class="text-dark" title="Pour supprimer le commentaire"><i class="p-2 fas fa-trash-alt fa-lg"></i></a>
            </div>
        </div>
<?php
    }
    unset($dataComment);
}
?>
<?php
$countWarning =0;
foreach ($result as $dataComment){

    if ($dataComment['commentReport'] == 'waiting' && $dataComment['startingCommentId'] == 0) {
        $countWarning++;
        if ($countDanger == 1) {echo"<h5>Il y a de nouveaux commentaires que vous n'avez pas validé :</h5>";}
?>
        <div class="d-flex flex-row mb-4 border border-warning">
            <div class="d-flex flex-column col-11 sansPadding ">
                <div class="d-flex flex-row bg-warning text-white">
                    <div class="commentsNews col">Chap. <?= $dataComment['commentBlogPostId']; ?></div>
                    <div class="commentsNews col"><?php if ($dataComment['commentsUserId'] != 2) {
                                                        echo $dataComment['userPseudo'];
                                                    }; ?></div>
                    <div class="commentsNews col"><?= $dataComment['commentAuthor']; ?></div>
                    <div class="commentsNews col"><?= $dataComment['commentDate_fr']; ?></div>
                </div>
                <div>
                    <?php

                    echo '<p class="commentaireTexte">' . htmlspecialchars($dataComment['commentContents']) . '</p>';

                    if ($data['answerId'] != 0) {
                        echo '<hr><p class="commentaireTexte">Votre réponse : <br>';
                        echo '<em>' . $dataComment['answerContents'] . '</em></p>';
                    }
                    ?>


                </div>
            </div>
            <div class="p-2 d-flex col-1 text-center pictoCommentsAdmin">
                <a href="index.php?action=commentsValidation&id=<?= $dataComment['commentId'] ?>" class="text-dark" title="Pour valider le commentaire"><i class="p-2 fas fa-check-square fa-lg"></i></a>
                <a href="index.php?action=commentsModify&id=<?= $dataComment['commentId'] ?>" class="text-dark" title="Pour répondre au commentaire ou corriger votre réponse"><i class="p-2 fas fa-pencil-alt fa-lg "></i></a>
                <a href="index.php?action=commentsDelete&id=<?= $dataComment['commentId'] ?>" class="text-dark" title="Pour supprimer le commentaire"><i class="p-2 fas fa-trash-alt fa-lg"></i></a>
            </div>
        </div>
<?php
    }
    unset($dataComment);
}

$comments->closeCursor();
$posts->closeCursor();

$content = ob_get_clean();
require('view/template.php');

?>