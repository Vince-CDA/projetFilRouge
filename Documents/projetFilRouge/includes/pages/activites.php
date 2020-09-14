<?php

   $idboutonsuccess = 'ajoutactivite';
   $valueboutonsuccess = 'Ajouter activité...';
   $liensuite = 'Consulter l\'activité';
   $pagename = 'activitecontent';
    //la requete de la table page
    $reponse = $BDD->query('SELECT * FROM activite');
    
    ?>

    <div class="row justify-content-center justify-content-sm-start mt-5 ml-9">
    <?php
    if (isset($_SESSION['User_Level']) && !empty($_SESSION['User_Level'])) {
        //Est-ce que l'utilisateur veut voir son propre profil ou a-t-il les droits d'aller en voir un autre ?
        if ($_SESSION['User_Level'] > 1) {
            ?>
    <div class="col-12">
                <a href="page-ajoutactivite"> 
                <button id= <?php echo $idboutonsuccess; ?> 
                type="submit" 
                class="btn btn-success float-right lead">
                <?php echo $valueboutonsuccess; ?>
                </button>
                </a>
                </form>
            </div>
    <?php
        }
    } ?>
<?php

    //boucle les données récupérées
    while ($donnees = $reponse->fetch()) {
        //Mise du texte de la requête dans une variable
        $texte = $donnees['Description'];
        //Décode du texte
        $texte = urldecode($texte);
        //Remplacement des balises titres par des espaces pour l'affichage dans la "mininews"
        $texte = str_replace('</h1>', '    ', $texte);
        $texte = str_replace('</h2>', '    ', $texte);
        $texte = str_replace('</h3>', '    ', $texte);
        $texte = str_replace('<script>', ' ', $texte);
        $texte = str_replace('</script>', ' ', $texte);
        $texte = str_replace('<style>', ' ', $texte);
        $texte = str_replace('</style>', ' ', $texte);
        //Balises enlevées
        $texte = strip_tags($texte);
        //Mise en variable de la donnée de l'ID de la news
        $idactivite = $donnees['IdActivite'];
        $titreactivite = $donnees['IntituleActivite'];
        $fichieractivite = $donnees['Fichier'];
        if ($fichieractivite == ' ') {
            $fichieractivite = $directory_img_upload.'defaut.png';
        }
        $date = $donnees['DDebut'];
        
        //On inclus Newsmini pour l'affichage de l'aperçu de la news.
        include('./includes/template/activitemini.php');
    }


?>
</div>
?>