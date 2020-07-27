<?php
//Connexion à la base de données MySQL en local
$BDD = new PDO(
    'mysql:host=localhost;dbname=test;charset=utf8',
    'root',
    '');

//Affichage des erreurs SQL (mode dev)
$BDD->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

/* Tableau de ma barre de navigation */

$NavBar = array('accueil'=>'Accueil', 'news'=>'News', 'activites'=>'Activités', 'galerie'=>'Galerie', 'historique'=>'Historique');

$MonModalTitre = '';
$MonModalTexte = '';
$MonModalBouton = '';
$User_Level = '0';
?>