
<!DOCTYPE html>
    <!--    Langue du site (pour traduction)    -->

<html lang="fr">

    <!--    Démarrage du Head    -->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1"><!--  -->
    <!--    Document Title-->
    <title><?php echo $Titre; ?></title><!--  -->
    <!--    Favicons-->
    <link rel="apple-touch-icon" sizes="180x180" href="./images/favicons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="./images/favicons/favicon-32x32.png">
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
    <!-- Photobox -->
    <link href="./libs/photobox/photobox.css" rel="stylesheet">
    <link href="./libs/photobox/photobox.ie.css" rel="stylesheet">
    <!-- Open Street Map -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==" crossorigin="">
    <!-- FancyBox -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css">
    <link href="./css/style.css" rel="stylesheet">
    <link href="./css/custom.css" rel="stylesheet">
    <!-- Fichier main custom -->
    <link href="./css/main.css?v1.1601109118" rel="stylesheet">
    <!-- CSS Spécial Wysiwyg -->
    <link rel="stylesheet" href="./css/image.css" />
    <!-- Canonical pour les moteurs de recherche -->
    <link rel="canonical" href="http://cda27.s1.2isa.org/page-<?php echo isset($_GET['page']) ? $_GET['page'] : 'accueil' ;?>" />
<!-- Matomo -->
<script type="text/javascript">
  var _paq = window._paq = window._paq || [];
  /* tracker methods like "setCustomDimension" should be called before "trackPageView" */
  _paq.push(["setDocumentTitle", document.domain + "/" + document.title]);
  _paq.push(['trackPageView']);
  _paq.push(['enableLinkTracking']);
  (function() {
    var u="//cda27.s1.2isa.org/matomo/";
    _paq.push(['setTrackerUrl', u+'matomo.php']);
    _paq.push(['setSiteId', '1']);
    var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
    g.type='text/javascript'; g.async=true; g.src=u+'matomo.js'; s.parentNode.insertBefore(g,s);
  })();
</script>
<!-- Matomo si javascript n'est pas démarré sur le client -->
<noscript><p><img src="//cda27.s1.2isa.org/matomo/matomo.php?idsite=1&amp;rec=1" style="border:0;" alt="" /></p></noscript>
<!-- End Matomo Code -->
<!-- Fin du head -->
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
<!-- On inclus la page de modal tout en la laissant 'hide' tant qu'il n'y a pas de contenu html dans son corps (voir main.js) -->

    <?php include('./includes/template/modal.php') ?>
    <div class="znav-container" id="znav-container">
        <div class="container">
            <nav class="navbar navbar-expand-lg"><a class="navbar-brand" href="./index.php">Moto Club Millau Passion</a><button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation"><span class="hamburger hamburger--emphatic"><span class="hamburger-box"><span class="hamburger-inner"></span></span></span></button>
                <div class="collapse navbar-collapse" id="navbarNavDropdown">
                    <ul class="navbar-nav pos-lg-absolute absolute-centered-lg">
                        <!-- Boucle pour afficher ma barre de navigation basique ($NavBar présent dans config.php donc édition possible !) -->
                        <?php
                        foreach ($NavBar as $key => $value) {
                            echo '<li><a href="page-'.$key.'">'.$value.'</a></li>';
                        }
                        ?>
                        <!-- Ancienne barre de navigation, en souvenir....
                        <li><a href="page-accueil">Accueil</a></li>
                        <li><a href="page-news">News</a></li>
                        <li><a href="page-activites">Activités</a></li>
                        <li><a href="page-galerie">Galerie</a></li>
                        <li><a href="page-historique">Historique</a></li>
                        <li><a href="page-search"><span class="fa fa-search"></span></a></li>
                        -->
                    </ul>
                        <!-- Condition si connecté alors afficher bouton déroulant avec : "Prénom Nom" -> "Mon profil"/"Membres"/"Déconnexion" & si Admin "Ajouter une activité" 
                    !!!!!!!!!!!!!!!!!!!!!    Bientôt ajout de "Voir les inscriptions aux activités" -->
                    <ul class="navbar-nav ml-auto">
                        <?php if (isset($_SESSION['User_Level']) && $_SESSION['User_Level'] > 0) {
                            ?>

                                <button class="btn btn-primary btn-capsule btn-sm dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    <?php  echo $_SESSION['Prenom'].' '.$_SESSION['Nom'] ?>
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu shadow" aria-labelledby="dropdownMenu1">
                                    <li><a class="menu-deroul" href="page-profil-<?php echo $_SESSION['Id'] ?>">Mon profil</a></li>
                                    <li><a class="menu-deroul" href="page-membres">Membres</a></li>
                                    <?php if (isset($_SESSION['User_Level']) && $_SESSION['User_Level'] > 1) {
                                ?>
                                    <li><a class="menu-deroul" href="page-ajoutactivite">Ajouter une activité</a></li>
                                    <li><a class="menu-deroul" href="page-ajoutnews">Ajouter une nouvelle</a></li>
                                    <?php
                            } ?>
                                    <li role="separator" class="menu-deroul divider"></li>
                                    <li><a class="menu-deroul" href="./index.php?deconnexion=1" alt="Déconnexion" title="Cliquez-ici pour se déconnecter">Déconnexion</a></li>
                                </ul>
                        <?php
                        } else {
                            //Sinon je ne suis pas connecté alors je peux voir Connexion et Inscription
                            ?>
                        <li><a href="page-connexion">Connexion</a></li>
                        <li><a class="btn btn-primary btn-capsule btn-sm" href="page-inscription">Inscription</a></li>
                        <?php
                        } ?>
                    </ul>
                </div>
            </nav>
        </div>
    </div>
    