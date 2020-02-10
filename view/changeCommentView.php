<?php 
$title = 'Mon blog'; 
session_start();

ob_start();

?>
        
<h1>Mon super blog !</h1>
<p>Corriger un commentaire :</p>
 <form action="index.php?action=updateComment&id=<?= $oneComment['id'] ?>" method="POST">
   <textarea name="comment"  cols="30" rows="10">
      <?= $oneComment['comment'] ?>
   </textarea>
   <input type="hidden" name="id" value="<?= $oneComment['id'] ?>">
   <input type="submit" value="save">
 </form>
        
<?php
$post->closeCursor();
$content = ob_get_clean(); 

require('template.php'); 

?>