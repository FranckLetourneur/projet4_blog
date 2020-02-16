<?php 

ob_start(); 
if (isset($post))
{
  while ($data = $post->fetch())
    {
      $blogPostContents = $data['blogPostContents'];
      $blogPostTitle = $data['blogPostTitle'];
      $blogPostId = $data['blogPostId'];
    }
  $post->closeCursor();
}
else
{
  $blogPostContents = '';
  $blogPostTitle = 'indiquer un titre';
  $blogPostId = 0;
}


?>
<form action="index.php?action=saveNewPost" method="post">
    <input name="blogPostTitle" value="<?= $blogPostTitle ?>">
    <input type="hidden" name="blogPostId" value="<?= $blogPostId ?>">
    <textarea name="textPost" id="myText">
         
    </textarea>
    <button type="submit" id="submitButton" class="btn btn-info" name="bouton" value="quitter">Sauvegarder & quitter</button>
    <button type="submit" id="submitButton2" class="btn btn-info" name="bouton" value="continuer">Sauvegarder & continuer</button>

</form>
<script type="text/javascript">
  tinymce.init({
    selector: '#myText',
    height: 450,
    language: 'fr_FR',
    language_url : 'public/js/fr_FR.js',
    plugins: [
      'advlist autolink link image lists charmap print preview hr anchor pagebreak ',
      'searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime nonbreaking',
      'table paste help'
    ],
    toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify |' +
      ' bullist numlist outdent indent | link image | print preview media fullpage | ' +
      'forecolor backcolor emoticons | help',
    menu: {
      favs: {title: 'My Favorites', items: 'code visualaid | searchreplace | spellchecker | emoticons'}
    },
    menubar: 'favs file edit view insert format tools table help',
    content_css: 'css/content.css'
  });
  

  </script>
<?php
 

$content = ob_get_clean(); 
require('view/template.php'); 

