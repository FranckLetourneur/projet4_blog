<?php 

ob_start(); 
?>
<h2>Voici tous les Chapitres créés</h2>

<?php
foreach($posts as $data)
{
    if ($data['blogPostStatus'] != 'inTrash') {
        if ($data['blogPostStatus'] == 'inRead') {
            $tricolore = 'Green';
        }
        else 
        {
            $tricolore = 'Red';
        }
    
        ?>
        <div class="p-2 m-2 rounded bg-info d-flex justify-content-between " >
            <div class="">
                <?= $data['blogPostId'] ?> • <?= $data['blogPostTitle'] ?><br>
                <?= substr($data['blogPostContents'],0,100) ?>
            </div>
            <div class="text-center">
                <a href="index.php?action=modifyPost&id=<?= $data['blogPostId'] ?>" class="text-dark" title="Pour corriger ce chapitre"><i class="p-2 fas fa-pencil-alt fa-lg "></i></a>
                <a href="index.php?action=modifyPostStatus&id=<?= $data['blogPostId'] ?>" title="Pour ouvrir ce chapitre à la lecture">
                    <img src="public/image/tricolor<?= $tricolore ?>.png" alt="Feux tricolores indiquant le status de l'article" >
                </a>
                
                <a href="index.php?action=deletePost&id=<?= $data['blogPostId'] ?>" onclick=" return confirm('Etes-vous sûr de vouloir supprimer ce commentaire ? ');"  class="text-dark" title="Pour supprimer ce chapitre"><i class="p-2 fas fa-trash-alt fa-lg"></i></a>
                
            </div> 
            
        </div>
<?php
    }
}
echo "<p>ici pour voir ceux mis à la poubelle</p>";
$content = ob_get_clean(); 
require('view/frontend/template.php'); 

?>

