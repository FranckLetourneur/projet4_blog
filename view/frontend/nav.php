<nav class="navbar navbar-expand-lg navbar-light  border border-info rounded shadow-lg">
    <a class="navbar-brand text-info" href="index.php">Billet simple pour l'Alaska</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    
    <div class="collapse navbar-collapse " id="navbarNavDropdown">
        <ul class="navbar-nav">
            <li class="nav-item <?php if ($_GET['action'] === 'author)') {echo "active";}?>">
                <a class="nav-link" href="author">A propos de moi <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="contact">contact</a>
            </li>
            <?php
                if (isset($_SESSION['userRole']) && $_SESSION['userRole'] == 0)
               {
            ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Menu auteur
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="newPost">Ecrire un nouveau chapitre</a>
                        <a class="dropdown-item" href="listBlogPost">Lister tous les chapitres</a>
                        <a class="dropdown-item" href="numberBlogPost"> Numéroter les chapitres</a>
                        <a class="dropdown-item" href="manageTrash">Gérer la corbeille</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="commentsAdmin">Gérer les commentaires</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Menu lecteur
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="index.php?action=listPosts&list=list">accueil lecteur</a>
                    </div>
                </li>
            <?php
               } 

               if (isset($_SESSION['userPseudo']))
               {
                    echo '
                    <li class="nav-item">
                        <a class="nav-link" href="deconnexion">déconnexion</a>
                    </li>
                    ';
               }
               else
               {
                    echo '
                    <li class="nav-item">
                        <a class="nav-link" href="connexion">connexion</a>
                    </li>
                   ';
               }
            ?>

           
           
                
        </ul>
    </div>
</nav>



