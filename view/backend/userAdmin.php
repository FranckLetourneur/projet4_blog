<?php 

ob_start(); 
?>
    <h3>Voici la liste des internautes inscrits</h3>

    <table class="table table-hover">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Nom</th>
                <th scope="col">Dernier Chapitre lu</th>
                <th scope="col">Date d'inscription</th>
                <th scope="col">Dernière connexion</th>
            </tr>
        </thead>    
   <tbody>
<?php
foreach($users as $data)
{
    ?>
        <tr>
        <th scope="row"><?= $data->getUserId() ?></th>
            <td><?= $data->getUserPseudo() ?></td>
            <td><?= $data->getLastBlogPostRead() ?></td>
            <td><?= $data->getRegistrationDate() ?></td>
            <td><?= $data->getLastConnexionDate() ?></td>
            <td>
                <a href="index.php?action=eraseUser&id=<?= $data->getUserId() ?>" class="text-dark" onclick=" return confirm('Etes-vous sûr de vouloir supprimer définitivement ce membre ? ');"  title="Pour supprimer définitivement ce membre"><i class="p-2 fas fa-trash-alt fa-lg"></i></a>
            </td>
        </tr>
    <?php
}
echo "   </tbody>
</table>" ;   

$content = ob_get_clean(); 

require('view/frontend/template.php'); 

?>

