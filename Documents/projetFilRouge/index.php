<?php
/* Le site utilise les sessions (créé moi un fichier avec un numéro unique et fait correspondre des numéros de sessions serveur/client)*/
session_start();

if (isset($_GET['deconnexion']) and $_GET['deconnexion'] == '1') {
    /* Destruction de la session */
    $_SESSION = array();
    session_destroy();
    unset($_COOKIE['ticket']);
    header("location:index.php");
}

if (isset($_SESSION['Id'])) {
    //Si le $_COOKIE ticket est identique à $_SESSION ticket, alors on regènere le ticket valable 20 min
    if (isset($_COOKIE['ticket']) and $_COOKIE['ticket'] == $_SESSION['ticket']) {
        $ticket = session_id().microtime().rand(0, 9999999999);
        $ticket = hash('sha512', $ticket);
        $_SESSION['ticket'] = $ticket;
        setcookie('ticket', $ticket, time() + (60 * 20)); // Expire au bout de 20 min
    } else {
        //Sinon
        // On détruit la session
        //On réinitialise le tableau des $_SESSION à vide
        $_SESSION = array();
        session_destroy();
        unset($_COOKIE['ticket']);
        header('location:index.php');
    }
}

/* J'inclus mes fichier config avec mes logins de base de données local */

include('./config/config.php');
include('./config/configPHPMailer.php');
require_once('./libs/recaptchalib.php');

// J'inclus mes fonctions PHP

include('./libs/functions.php');

/* J'inclus les méthodes POST */

include('./libs/methode_post.php');

/* J'inclus les méthodes GET */

include('./libs/methode_get.php');

/* J'inclus le header de mon site */

include './includes/layout/header.php';


/* J'inclus le corps de ma page */

include './includes/pages/'.$MaPage.'.php';

/* J'inclus le footer de mon site */

include './includes/layout/footer.php';
