<?php 
session_start();

ob_start(); 

$errorMessage = $e->getMessage();
echo "<h1>une erreur c'est produite : </h1>";
echo "<h2>",$errorMessage,"</h2>";
$content = ob_get_clean(); 
require('template.php'); 

?>