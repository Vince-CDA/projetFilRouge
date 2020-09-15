<?php

   $idboutonsuccess = 'ajout';
   $valueboutonsuccess = 'Ajouter nouvelle...';
   $liensuite = 'Lire la suite...';
   $pagename = 'newscontent';
    //la requete de la table page
    $reponse = $BDD->query('SELECT * FROM nouvelle WHERE Diffusion = 1');
    ?>

    <div class="row justify-content-center justify-content-sm-start mt-5 margincustom">
    <?php if (isset($_SESSION['User_Level']) && $_SESSION['User_Level'] > 1) { ?>
            <div class="col-12">
                <a href="page-ajoutnews"> <button id= <?php echo $idboutonsuccess; ?> type="submit" class="btn btn-success float-right lead"><?php echo $valueboutonsuccess; ?></button></a>
                </div>   
                <?php } ?>     
<?php

    //boucle les données récupérées
    while ($donnees = $reponse->fetch()) {
        //Mise du texte de la requête dans une variable
        $texte = $donnees['Texte'];
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
        $idnews = $donnees['IdNouvelle'];
        $titrenews = $donnees['Titre'];
        $fichiernews = $donnees['Fichier'];
        if ($fichiernews == ' ') {
            $fichiernews = $directory_img_upload.'defaut.png';
        }
        //On inclus Newsmini pour l'affichage de l'aperçu de la news.
        include('./includes/template/newsmini.php');
    }


?>
</div>