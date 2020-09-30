<?php

   $idboutonsuccess = 'ajoutactivite';
   $valueboutonsuccess = 'Ajouter activité...';
   $liensuite = 'Consulter l\'activité';
   $pagename = 'activitecontent';

   if (isset($_GET['num']) && !empty($_GET['num'])) {
       $currentPage = (int) strip_tags($_GET['num']);
   } else {
       $currentPage = 1;
   }

if (!isset($_SESSION['User_Level'])) {
    $sql = 'SELECT COUNT(*) AS nb_articles FROM `activite` WHERE Publier = 1;';
    $query = $BDD->prepare($sql);
    $query->execute();

    $result = $query->fetch();
    $nbArticles = (int) $result['nb_articles'];
    $parPage = 6;
    $pages = ceil($nbArticles / $parPage);
    $premier = ($currentPage * $parPage) - $parPage;
    $sql = 'SELECT * FROM activite WHERE Publier = 1 ORDER BY IdActivite DESC LIMIT :premier, :parpage;';
    $query = $BDD->prepare($sql);
    $query->bindValue(':premier', $premier, PDO::PARAM_INT);
    $query->bindValue(':parpage', $parPage, PDO::PARAM_INT);
    $result = $query->execute();
} elseif (isset($_SESSION['User_Level'])) {
    $sql = 'SELECT COUNT(*) AS nb_articles FROM `activite` WHERE Publier = 1 OR Publier = 0 ;';
    $query = $BDD->prepare($sql);
    $query->execute();

    $result = $query->fetch();
    $nbArticles = (int) $result['nb_articles'];
    $parPage = 6;
    $pages = ceil($nbArticles / $parPage);
    $premier = ($currentPage * $parPage) - $parPage;
    $sql = 'SELECT * FROM activite WHERE Publier = 1 OR Publier = 0 ORDER BY IdActivite DESC LIMIT :premier, :parpage;';
    $query = $BDD->prepare($sql);
    $query->bindValue(':premier', $premier, PDO::PARAM_INT);
    $query->bindValue(':parpage', $parPage, PDO::PARAM_INT);
    $result = $query->execute();
}

    //la requete de la table page
    
    ?>

    <div class="row justify-content-center justify-content-sm-start mt-5 col-10 m-auto">
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
        while ($donnees = $query->fetch()) {
            //Mise du texte de la requête dans une variable
            $texte = strip_tags($donnees['Description']);
            /*
            ------------ INUTILE GRACE AU STRIP_TAGS ------------
             $texte = $texte;
            //Remplacement des balises titres par des espaces pour l'affichage dans la "mininews"
            $texte = str_replace('</h1>', '    ', $texte);
            $texte = str_replace('</h2>', '    ', $texte);
            $texte = str_replace('</h3>', '    ', $texte);
            $texte = str_replace('<script>', ' ', $texte);
            $texte = str_replace('</script>', ' ', $texte);
            $texte = str_replace('<style>', ' ', $texte);
            $texte = str_replace('</style>', ' ', $texte);
            //Balises enlevées
            ------------ INUTILE GRACE AU STRIP_TAGS ------------
            */
            //Mise en variable de la donnée de l'ID de la news
            $idactivite = $donnees['IdActivite'];
            $titreactivite = strip_tags($donnees['IntituleActivite']);
            $fichieractivite = $donnees['Fichier'];
            if ($fichieractivite == ' ') {
                $fichieractivite = $directory_img_upload.'defaut.png';
            }
            $date = $donnees['DDebut'];
            if ($donnees['Publier'] > 0) {
                $bonus = '(activité visible pour tous)';
            } else {
                $bonus = '(activité visible par les membres)';
            }
            //On inclus Newsmini pour l'affichage de l'aperçu de la news.
            include('./includes/template/activitemini.php');
        }
?>
<div class="row justify-content-center col-12">
                    <ul class="pagination">
                        <!-- Lien vers la page précédente (désactivé si on se trouve sur la 1ère page) -->
                        <li class="page-item <?= ($currentPage == 1) ? "disabled" : "" ?>">
                            <a href="./page-activites-num-<?= $currentPage - 1 ?>" class="page-link">Précédente</a>
                        </li>
                        <?php for ($page = 1; $page <= $pages; $page++): ?>
                          <!-- Lien vers chacune des pages (activé si on se trouve sur la page correspondante) -->
                          <li class="page-item <?= ($currentPage == $page) ? "active" : "" ?>">
                                <a href="./page-activites-num-<?= $page ?>" class="page-link"><?= $page ?></a>
                            </li>
                        <?php endfor ?>
                          <!-- Lien vers la page suivante (désactivé si on se trouve sur la dernière page) -->
                          <li class="page-item <?= ($currentPage == $pages) ? "disabled" : "" ?>">
                            <a href="./page-activites-num-<?= $currentPage + 1 ?>" class="page-link">Suivante</a>
                        </li>
                    </ul>
                </div>
</div>
</div>
