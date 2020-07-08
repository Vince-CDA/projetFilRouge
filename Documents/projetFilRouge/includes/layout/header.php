
<!DOCTYPE html>

<html lang="en-US">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1"><!--  -->
    <!--    Document Title-->
    <!-- =============================================-->
    <title><?php echo $titre; ?></title><!--  -->
    <!--    Favicons-->
    <!--    =============================================-->
    <link rel="apple-touch-icon" sizes="180x180" href="./images/favicons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="./images/favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="./images/favicons/favicon-16x16.png">
    <link rel="shortcut icon" type="image/x-icon" href="./images/favicons/favicon.ico">
    <link rel="manifest" href="./images/favicons/manifest.json">
    <link rel="mask-icon" href="./images/favicons/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileImage" content="./images/favicons/mstile-150x150.png">
    <meta name="theme-color" content="#ffffff"><!--  -->
    <!--    Stylesheets-->
    <!--    =============================================-->
    <!-- Default stylesheets-->
    <link href="./lib/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet"><!-- Template specific stylesheets-->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:200,300,400,600,700,900" rel="stylesheet">
    <link href="./lib/iconsmind/iconsmind.css" rel="stylesheet">
    <link href="./lib/flexslider/flexslider.css" rel="stylesheet">
    <link href="./lib/loaders.css/loaders.min.css" rel="stylesheet">
    <link href="./lib/remodal/dist/remodal.css" rel="stylesheet">
    <link href="./lib/remodal/dist/remodal-default-theme.css" rel="stylesheet">
    <link href="./lib/semantic-ui-dropdown/dropdown.min.css" rel="stylesheet">
    <link href="./lib/semantic-ui-accordion/accordion.min.css" rel="stylesheet">
    <link href="./lib/semantic-ui-transition/transition.min.css" rel="stylesheet">
    <link href="./lib/owl.carousel/dist/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="./lib/owl.carousel/dist/assets/owl.theme.default.min.css" rel="stylesheet">
    <link href="./lib/iconsmind/iconsmind.css" rel="stylesheet">
    <link href="./lib/lightbox2/dist/css/lightbox.css" rel="stylesheet">
    <link href="./lib/hamburgers/dist/hamburgers.min.css" rel="stylesheet"><!-- Main stylesheet and color file-->
    <link href="./css/style.css" rel="stylesheet">
    <link href="./css/custom.css" rel="stylesheet">
    <!-- Fichier main custom -->
    <link href="./css/main.css?v1.<?php echo time();?>" rel="stylesheet">
</head>
<body data-spy="scroll" data-target=".inner-link" data-offset="60">
<div class="preloader" id="preloader">
    <div class="preloader-wrapper big active">
        <div class="spinner-layer spinner-white-only">
            <div class="circle-clipper left">
                <div class="circle"></div>
            </div>
            <div class="gap-patch">
                <div class="circle"></div>
            </div>
            <div class="circle-clipper right">
                <div class="circle"></div>
            </div>
        </div>
    </div>
</div>
<main>
    <?php include('./includes/template/modal.php') ?>
    <div class="znav-container" id="znav-container">
        <div class="container">
            <nav class="navbar navbar-expand-lg"><a class="navbar-brand" href="./index.php">Moto Club Millau Passion</a><button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation"><span class="hamburger hamburger--emphatic"><span class="hamburger-box"><span class="hamburger-inner"></span></span></span></button>
                <div class="collapse navbar-collapse" id="navbarNavDropdown">
                    <ul class="navbar-nav pos-lg-absolute absolute-centered-lg">
                        <!-- Boucle pour afficher ma barre de navigation -->
                        <?php
                        foreach ($navbar as $key => $value) {
                            echo '<li><a href="./index.php?page='.$key.'">'.$value.'</a></li>';
                        }
                        ?>

                        <!--
                        <li><a href="./index.php?page=accueil">Accueil</a></li>
                        <li><a href="./index.php?page=news">News</a></li>
                        <li><a href="./index.php?page=activites">Activités</a></li>
                        <li><a href="./index.php?page=galerie">Galerie</a></li>
                        <li><a href="./index.php?page=historique">Historique</a></li>
                        <li><a href="./index.php?page=search"><span class="fa fa-search"></span></a></li>
                        -->
                    </ul>
                    <ul class="navbar-nav ml-auto">
                        <?php if(isset($_SESSION['nom'])){ ?>

                                <button class="btn btn-primary btn-capsule btn-sm dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    <?php  echo $_SESSION['prenom'].' '.$_SESSION['nom'] ?>
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu shadow" aria-labelledby="dropdownMenu1">
                                    <li><a class="menu-deroul" href="./index.php?page=profil&id=<?php echo $_SESSION['id'] ?>">Mon profil</a></li>
                                    <li><a class="menu-deroul" href="./index.php?page=membres">Membres</a></li>
                                    <li><a class="menu-deroul" href="./index.php?page=activités">Ajouter une activité</a></li>
                                    <li role="separator" class="menu-deroul divider"></li>
                                    <li><a class="menu-deroul" href="./index.php?deconnexion=1" alt="Déconnexion" title="Cliquez-ici pour se déconnecter">Déconnexion</a></li>
                                </ul>
                        <?php }else{?>
                        <li><a href="./index.php?page=connexion">Connexion</a></li>
                        <li><a class="btn btn-primary btn-capsule btn-sm" href="./index.php?page=inscription">Inscription</a></li>
                        <?php } ?>
                    </ul>
                </div>
            </nav>
        </div>
    </div>