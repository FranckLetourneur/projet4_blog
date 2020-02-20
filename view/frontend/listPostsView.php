<?php 

ob_start(); 
echo "<div class='d-flex justify-content-around'>";

foreach ($posts as $data)
    {
        if ($data['blogPostStatus'] == 'inRead')
        {
    ?>

    <div class="card" >
        <img src="public/image/alaska.jpg" class="card-img-top" alt="...">
        <div class="card-body">
            <h5 class="card-title">Chap. <?= htmlspecialchars($data['blogPostId'])  ?> : <?= htmlspecialchars($data['blogPostTitle'])  ?></h5>
            <p class="card-text"><?= substr($data['blogPostContents'],0,200) ?></p>
            <a href="index.php?action=post&id=<?= $data['blogPostId']?>" class="btn btn-primary">Lire la suite</a>
        </div>
    </div>


    <?php
        }
    }
echo "</div>";


$content = ob_get_clean(); 
require('template.php'); 





    
                
                