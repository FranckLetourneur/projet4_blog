<?php
// On démarre la session AVANT d'écrire du code HTML
session_start();
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link href="https://fonts.googleapis.com/css?family=Merienda+One&display=swap" rel="stylesheet"> 
    <link href="public/css/bootstrap.css" rel="stylesheet">
    <link href="public/css/style.css" rel="stylesheet">

    <title>Billet simple pour l'Alaska, de Jean Forteroche</title>
</head>

<body>

    <div class="container-fluid">
        <header>
            <h1>
                Jean Forteroche
            </h1> 
        </header>

        <nav class="navbar navbar-expand-lg navbar-light  border border-info rounded shadow-lg">
            <a class="navbar-brand text-info" href="index.php">Billet simple pour l'Alaska</a>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown"
                aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse " id="navbarNavDropdown">
                <ul class="navbar-nav">
                    <li class="nav-item active">
                        <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Lecture</a>
                    </li>
                    
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Menu auteur
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="#">Action</a>
                            <a class="dropdown-item" href="#">Another action</a>
                            <a class="dropdown-item" href="#">Something else here</a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?action=connexion">connexion</a>
                    </li>
                </ul>
            </div>
        </nav>
        <section id="section" class="border border-info rounded shadow-lg">

        <?= $content ?>      

        </section>
        <footer>
            <p>Site créé dans le cadre d'une formation Developpeur Web Junior chez OpenClassRoom</p>
        </footer>
    </div>



    <script src="public/js/jquery-3.4.1.js"></script>
    <script src="public/js/bootstrap.js"></script>
    <script src="public/js/myfunction.js"></script>
    
</body>

</html>