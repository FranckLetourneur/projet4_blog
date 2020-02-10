<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link href="https://fonts.googleapis.com/css?family=Merienda+One&display=swap" rel="stylesheet"> 
    <link href="public/css/bootstrap.css" rel="stylesheet">
    <link href="public/css/style<?php if (isset($_SESSION['userPseudo']) && isset($_SESSION['userRole']) == '0') {echo 'Admin';}?>.css" rel="stylesheet">

    <title>Billet simple pour l'Alaska, de Jean Forteroche</title>
</head>

<body>

    <div class="container-fluid">
        <header>
            <h1>
                Jean Forteroche
            </h1> 
        </header>

        <?php 
        include_once('nav.php');
        ?>
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