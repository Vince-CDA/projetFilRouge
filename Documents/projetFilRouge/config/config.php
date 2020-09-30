<?php
//Connexion à la base de données MySQL en local
$BDD = new PDO(
    'mysql:host=localhost;dbname=test;charset=utf8',
    'root',
    ''
);

//Affichage des erreurs SQL (mode dev)
$BDD->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

/* Tableau de ma barre de navigation - Ajouter une clé/valeur pour avoir un nouvel onglet sur le site */
$NavBar = array('accueil'=>'Accueil', 'news'=>'News', 'activites'=>'Activités', 'galerie'=>'Galerie', 'historique'=>'Historique');

//Initialisation de mon modal, titre, texte et bouton à vide
$MonModalTitre = '';
$MonModalTexte = '';
$MonModalBouton = '';

//Indication de l'userlevel à 0 (utile ?)
$User_Level = '0';

//Initialisation de $nouvelle à vide pour pouvoir l'inclure au WysiWyg pour un nouvel article
//Initialisation des titres de nouvelles à vide
//Initialisation des contenus de nouvelles à vides
$nouvelle = '';
$titlenews = '';


//$contenunews = ''; USELESS ?

$directory_img_fichier = './upload/fichier/';
//Chemin d'upload de pohtos pour les images profil
$directory_img_upload = './upload/images/';
$defautimg = 'defaut.jpg';
setlocale(LC_TIME, "fr_FR", "French");
$fmt = new IntlDateFormatter(
    "fr_FR" ,
    IntlDateFormatter::FULL,
    IntlDateFormatter::FULL,
    'Europe/Paris',
    IntlDateFormatter::GREGORIAN,
    "dd/MM/yyyy"
);
