<nav class="navbar navbar-expand-lg navbar-light  border border-info rounded shadow-lg">
    <a class="navbar-brand text-info" href="index.php">Billet simple pour l'Alaska</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    
    <div class="collapse navbar-collapse " id="navbarNavDropdown">
        <ul class="navbar-nav">
            <li class="nav-item <?php if ($_GET['action'] === 'author)') {echo "active";}?>">
                <a class="nav-link" href="#">L'auteur ? <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">contact</a>
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
                    <a class="dropdown-item" href="#">Action</a>
                    <a class="dropdown-item" href="#">Another action</a>
                    <a class="dropdown-item" href="#">Something else here</a>
                </div>
            </li>
            <?php
               } 

               if (isset($_SESSION['userPseudo']))
               {
                    echo '
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?action=deconnexion">déconnexion</a>
                    </li>
                    ';
               }
               else
               {
                    echo '
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?action=connexion">connexion</a>
                    </li>
                   ';
               }
            ?>

           
           
                
        </ul>
    </div>
</nav>



