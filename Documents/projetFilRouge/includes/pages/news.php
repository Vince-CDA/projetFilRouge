<?php 

   
    //la requete de la table page
    $reponse = $BDD->query('SELECT * FROM nouvelle');
    ?>

    <div class="row justify-content-center justify-content-sm-start mt-5 ml-9">
<?php 

    //boucle les données récupérées
    while ($donnees = $reponse->fetch()) {
        //Mise du texte de la requête dans une variable
        $texte = $donnees['Texte'];
        //Décode du texte 
        $texte = urldecode($texte);
        //Remplacement des balises titres par des espaces pour l'affichage dans la "mininews"
        $texte = str_replace('</h1>','    ', $texte);
        $texte = str_replace('</h2>','    ', $texte);
        $texte = str_replace('</h3>','    ', $texte);
        //Balises enlevées
        $texte = strip_tags($texte);
        //Mise en variable de la donnée de l'ID de la news
        $idnews = $donnees['IdNouvelle'];
        //On inclus Newsmini pour l'affichage de l'aperçu de la news.
        include('./includes/template/newsmini.php');
    } 


?>
</div>