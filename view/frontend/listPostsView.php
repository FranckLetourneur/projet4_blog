<?php 

ob_start(); 
echo "<div class='d-flex justify-content-around  flex-wrap'>";
foreach ($posts as $data)
    {
        
        if ($data->getBlogPostStatus() == 'inRead')
        {
    ?>

    <div class="card" >
        <img src="public/image/alaska.jpg" class="card-img-top" alt="...">
        <div class="card-body">
            <h5 class="card-title">Chap. <?= htmlspecialchars($data->getBlogPostId())  ?> : <?= htmlspecialchars($data->getBlogPostTitle())  ?></h5>
            <p class="card-text"><?= substr($data->getBlogPostContents() ,0,200) ?></p>
            <a href="index.php?action=post&id=<?= $data->getBlogPostId() ?>" class="btn btn-primary">Lire la suite</a>
        </div>
    </div>


    <?php
        }
    }
echo "</div>";
echo "<div class='text-center mt-2'>";
for ($i=1; $i <= $numberOfPages ; $i++) { 
    if ($i == $currentPage)
    {
        echo "<span class='btn btn-primary m-2'>$i </span>";
    }
    else
    {
        echo '<a href="index.php?action=listPosts&page='.$i.'" class="btn btn-info m-2"> '.$i. '</a>';
    }
}
echo "</div>";
$content = ob_get_clean(); 
require('template.php'); 





    
                
                
