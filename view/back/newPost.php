<?php 

ob_start(); 
?>
<form action="index.php?action=saveNewPost" method="post">
    <input name="blogPostTitle" >
    <textarea name="textPost" id="myText">
        qqssqs
    </textarea>
    <button type="submit" id="submitButton"class="btn btn-info">Sauvegarder</button>

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

