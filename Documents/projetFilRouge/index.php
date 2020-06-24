<?php

include './includes/layout/header.php';
/* Chargement du Header */

if (isset($_GET['page'])){
    $mapage = $_GET['page'];
}
else {
    $mapage = 'accueil';
}

if ($mapage=='accueil'||$mapage=='about') {
    include './includes/layout/pages/'.$mapage.'.php';
}
/* Chargement du Header */

include './includes/layout/footer.php';
/* Chargement du footer */
