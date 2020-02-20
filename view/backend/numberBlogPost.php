<?php 

ob_start(); 
?>
<h2>Voici tous les Chapitres créés, vous allez pouvoir les numéroter.</h2>
<h4 class="alert alert-danger">Attention, vous ne pouvez pas utiliser un numéro de chapitre existant. Cela entrainera une erreur vous obligeant à revenir à la page précedente</h4>

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
            <div class="text-center bg-warning p-2">
               <form action="updateBlogPostId" method="post" >
                    <input type="hidden" name="blogPostId" value="<?= $data['blogPostId'] ?>">
                    <input type="number" name="newBlogPostId">
                    <button type="submit" id="submitButton"class="btn btn-info" >Corriger</button>
               </form>     
            </div> 
            
        </div>
<?php
    }
}
echo "<h5>Si la liste des chapitres est correct et que vous souhaitez réinitialiser le compteur de chapitre : <a href='updateIncrementingBlogPost' class='text-dark'>cliquer ici</a></h5>";
$content = ob_get_clean(); 
require('view/frontend/template.php'); 

?>

