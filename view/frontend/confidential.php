<?php
ob_start(); 
?>        
<h2>Politique de confidentialité</h2>
<h4>Qui sommes-nous ?</h4>
<p>L’adresse de notre site Web est : http://franckletourneur.zd.fr/projet4. Il s’agit d’un site fictif réalisé au cours de la réalisation d’une formations Developpeur Web Junior avec Open Class Rooms
Utilisation des données personnelles collectées</p>
<h4>Commentaires</h4>
<p>Les commentaires que vous laissez sont stockés dans notre base de données. Si vous le souhaitez, sur simple demande, nous pourvons les effacer.</p>

<h4>Cookies• Utilisation et transmission de vos données personnelles</h4>
<p>Nous n'utilisons pas de cookies, mais si vous vous inscrivez, les informations seront conservées dans notre base de données.
</p>

<h4>Informations de contact</h4>
<p>Pour contacter le webmaster, merci de lui écrire à l’adresse : fletour@laposte.net</p>

                    
<?php
$content = ob_get_clean(); 
require('template.php'); 

?>

