<?php 

   
    //la requete de la table page
    $reponse = $BDD->query('SELECT * FROM nouvelle');
    ?>

    <div class="row justify-content-center justify-content-sm-start mt-5 ml-9">
<?php 

    //boucle les données récupérées
    while ($donnees = $reponse->fetch()) {
        $texte = $donnees['Texte'];
        $texte = urldecode($texte);
        $texte = str_replace('</h1>','    ', $texte);
        $texte = str_replace('</h2>','    ', $texte);
        $texte = str_replace('</h3>','    ', $texte);
        $texte = strip_tags($texte);
        $idnews = $donnees['IdNouvelle'];
        include('./includes/template/newsmini.php');
    } 


?>
</div>