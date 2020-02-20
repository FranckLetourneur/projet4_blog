<?php 

ob_start(); 
?>
<h2>Voici tous les Chapitres qui ont été mis à la corbeille</h2>
<h3 class="alert alert-danger">Attention, une suppression à cet endroit est définitive. Pas de retour en arrière possible</h3>
<?php
if (isset($posts)) {
    foreach($posts as $data)
    {
        if ($data['blogPostStatus'] == 'inTrash') {
                
            ?>
            <div class="p-2 m-2 rounded bg-info d-flex justify-content-between " >
                <div class="">
                    <?= $data['blogPostId'] ?> • <?= $data['blogPostTitle'] ?><br>
                    <?= substr($data['blogPostContents'],0,100) ?>
                </div>
                <div class="text-center">
                    <a href="index.php?action=unDeletePost&id=<?= $data['blogPostId'] ?>" class="text-dark" title="Sortir ce chapitre de la corbeille"><i class="p-2 fas fa-trash-restore fa-lg"></i></i></a>
                                
                    <a href="index.php?action=erasePost&id=<?= $data['blogPostId'] ?>" class="text-dark" title="Pour supprimer définitivement ce chapitre"><i class="p-2 fas fa-trash-alt fa-lg"></i></a>
                    
                </div> 
                
            </div>
    <?php
        }
    }
}
echo "<h5>Si vous venez de supprimer définitivement des articles, je vous conseille de gérer la numérotation: <a href='index.php?action=numberBlogPost'>ici</a></h5>";
$content = ob_get_clean(); 
require('view/frontend/template.php'); 

?>

