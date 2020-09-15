<?php
//Connexion à la base de données MySQL en local
$BDD = new PDO(
    'mysql:host=cda27.2isa.org;dbname=cda27_bd1;charset=utf8',
    'cda27',
    '3677cda27'
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

//Chemin d'upload de pohtos pour les images profil
$directory_img_upload = './upload/images/';
setlocale(LC_TIME, "fr_FR", "French");
