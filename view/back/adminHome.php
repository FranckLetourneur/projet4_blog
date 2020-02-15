<?php 

ob_start(); 
 echo "<h2>Salut Jean, comment ça va ?</h2>";
/*
while ($data = $posts->fetch())
    {
    }
$posts->closeCursor();
*/
$content = ob_get_clean(); 
require('view/template.php'); 

?>

