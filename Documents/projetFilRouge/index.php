<?php

/* J'inclus mon fichier config avec mes logins de base de données local */

include('./config/config.php');

/* Je récupère le résultat de la requête SQL  */

$reponse = $bdd->query('SELECT * FROM pages');

/* Je génère un tableau  */

$tbTitle = array();

/* Ma valeur $donnees sur les lignes de ma requête SQL $reponse */

while ($donnees = $reponse->fetch()) {
    /* Mon $tbTitle avec comme clée chaque valeur de la colonne 'Key' de mes $donnees sera égale à mes lignes $donnees correspondante */
    $tbTitle[$donnees['Key']] = $donnees;
}

/* Tableau de ma barre de navigation */

$navbar = array('accueil'=>'Accueil', 'news'=>'News', 'activites'=>'Activités', 'galerie'=>'Galerie', 'historique'=>'Historique');


/* Si ma valeur page contient une valeur existante dans le tableau de mes titres alors $mapage = laValeur */

if (isset($_GET['page']) && array_key_exists($_GET['page'],$tbTitle)) {
    $mapage = $_GET['page'];
} else {
    $mapage = 'accueil';
}

/* Mon titre de page présent dans header est donc égal au titre de la valeur correspondante au tableau suivant la page. (accueil par défaut) */

$titre = $tbTitle[$mapage]['Titre'];

/* J'inclus le header de mon site */

include './includes/layout/header.php';


/* J'inclus le corps de ma page */

include './includes/layout/pages/'.$mapage.'.php';

/* J'inclus le footer de mon site */

include './includes/layout/footer.php';
