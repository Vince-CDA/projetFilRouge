<?php
//Connexion à la base de données MySQL en local
$bdd = new PDO(
    'mysql:host=localhost;dbname=test;charset=utf8',
    'root',
    '');

//Affichage des erreurs SQL (mode dev)
$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

/* Tableau de ma barre de navigation */

$navbar = array('accueil'=>'Accueil', 'news'=>'News', 'activites'=>'Activités', 'galerie'=>'Galerie', 'historique'=>'Historique');



?>