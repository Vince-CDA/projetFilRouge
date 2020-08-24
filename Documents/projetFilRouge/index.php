<?php
/* Le site utilise les sessions (créé moi un fichier avec un numéro unique et fait correspondre des numéros de sessions serveur/client)*/
session_start();

if(isset($_GET['deconnexion']) AND $_GET['deconnexion'] == '1'){
    /* Destruction de la session */
    session_destroy();
    header("location:index.php");

}

/* J'inclus mon fichier config avec mes logins de base de données local */

include('./config/config.php');
include ('./config/configPHPMailer.php'); 

/* J'inclus les méthodes POST */

include('./libs/methode_post.php');

/* J'inclus les méthodes GET */

include ('./libs/methode_get.php');


/* J'inclus le header de mon site */

include './includes/layout/header.php';

/* J'inclus le corps de ma page */

include './includes/pages/'.$MaPage.'.php';

/* J'inclus le footer de mon site */

include './includes/layout/footer.php';

var_dump($_SESSION['User_Level']);