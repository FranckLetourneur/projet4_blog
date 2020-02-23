<?php 

ob_start(); 
?>
<h2>Voici tous les Chapitres créés</h2>

<?php
foreach($posts as $data)
{
    if ($data->getBlogPostStatus() != 'inTrash') {
        if ($data->getBlogPostStatus() == 'inRead') {
            $tricolore = 'Green';
        }
        else 
        {
            $tricolore = 'Red';
        }
    
        ?>
        <div class="p-2 m-2 rounded bg-info d-flex justify-content-between" >
            <div class="h5">
                <?= $data->getBlogPostId() ?> • <?= $data->getBlogPostTitle() ?>
            </div>
            <div class="text-center">
                <a href="index.php?action=modifyPost&id=<?= $data->getBlogPostId() ?>" class="text-dark" title="Pour corriger ce chapitre"><i class="p-2 fas fa-pencil-alt fa-lg "></i></a>
                <a href="index.php?action=modifyPostStatus&id=<?= $data->getBlogPostId() ?>" title="Pour ouvrir ce chapitre à la lecture">
                    <img src="public/image/tricolor<?= $tricolore ?>.png" alt="Feux tricolores indiquant le status de l'article" >
                </a>
                
                <a href="index.php?action=deletePost&id=<?= $data->getBlogPostId() ?>" onclick=" return confirm('Etes-vous sûr de vouloir supprimer ce commentaire ? ');"  class="text-dark" title="Pour supprimer ce chapitre"><i class="p-2 fas fa-trash-alt fa-lg"></i></a>
                
            </div> 
            
        </div>
<?php
    }
}
echo "<p><a href='manageTrash'>ici</a> pour voir ceux mis à la poubelle</p>";
$content = ob_get_clean(); 
require('view/frontend/template.php'); 

?>

