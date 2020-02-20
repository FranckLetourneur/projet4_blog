<?php 

ob_start(); 
?>        
<div class="d-flex">
    <div >
        <img src="public/image/photo_de_Jean_Forteroche.png" alt="portrait de Jean Forteroche" width="300"> 
    </div>
    <div class="lead pl-5 pr-5">
    Je m'appelle Jean Forteroche et je suis acteur et écrivain.
    Je travaille sur mon nouveau roman : "Billet simple pour l'Alaska". Il s'agit du premier roman que j'écris depuis longtemps (comme vous le savez, ma carrière d'acteur m'a beaucoup occupé ces dernières années).
    Pour vivre avec notre temps, j'ai décidé d'innover et de l'offrir en avant première à mes fidèles lecteurs.
    Billet simple pour l'Alaka sera publier par épisode sur ce site.

    Je vous invite également à commenter les chapitres après votre lecture.

    J'espère que cette expérience littéraire vous plaira autant qu'à moi.

    A bientôt pour le premier chapitre.

    Jean Forteroche.
    </div>

                    
<?php
$content = ob_get_clean(); 
require('template.php'); 

?>

