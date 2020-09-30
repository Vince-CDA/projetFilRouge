<?php

   $idboutonsuccess = 'ajout';
   $valueboutonsuccess = 'Ajouter nouvelle...';
   $liensuite = 'Lire la suite...';
   $pagename = 'newscontent';
   if (isset($_GET['num']) && !empty($_GET['num'])) {
       $currentPage = (int) strip_tags($_GET['num']);
   } else {
       $currentPage = 1;
   }

if (!isset($_SESSION['User_Level'])) {
    // On détermine le nombre total d'articles
    $sql = 'SELECT COUNT(*) AS nb_articles FROM `nouvelle` WHERE Diffusion = 1;';
    $query = $BDD->prepare($sql);
    $query->execute();
    // On récupère le nombre d'articles
    $result = $query->fetch();
    $nbArticles = (int) $result['nb_articles'];
    // On détermine le nombre d'articles par page
    $parPage = 6;
    // On calcule le nombre de pages total
    $pages = ceil($nbArticles / $parPage);
    // Calcul du 1er article de la page
    $premier = ($currentPage * $parPage) - $parPage;
    $sql = 'SELECT * FROM nouvelle WHERE Diffusion = 1 ORDER BY IdNouvelle DESC LIMIT :premier, :parpage;';
    // On prépare la requête
    $query = $BDD->prepare($sql);
    $query->bindValue(':premier', $premier, PDO::PARAM_INT);
    $query->bindValue(':parpage', $parPage, PDO::PARAM_INT);
    // On l'exécute
    $result = $query->execute();
} elseif (isset($_SESSION['User_Level']) && $_SESSION['User_Level'] < 2) {
    $sql = 'SELECT COUNT(*) AS nb_articles FROM `nouvelle` WHERE Diffusion = 2 OR Diffusion = 1 ;';
    $query = $BDD->prepare($sql);
    $query->execute();
    $result = $query->fetch();
    $nbArticles = (int) $result['nb_articles'];
    $parPage = 6;
    $pages = ceil($nbArticles / $parPage);
    $premier = ($currentPage * $parPage) - $parPage;
    $sql = 'SELECT * FROM nouvelle WHERE Diffusion = 2 OR Diffusion = 1 ORDER BY IdNouvelle DESC LIMIT :premier, :parpage;';
    $query = $BDD->prepare($sql);
    $query->bindValue(':premier', $premier, PDO::PARAM_INT);
    $query->bindValue(':parpage', $parPage, PDO::PARAM_INT);
    $result = $query->execute();
} elseif (isset($_SESSION['User_Level']) && $_SESSION['User_Level'] > 1) {
    $sql = 'SELECT COUNT(*) AS nb_articles FROM `nouvelle` WHERE Diffusion = 0 OR Diffusion = 1 OR Diffusion = 2;';
    $query = $BDD->prepare($sql);
    $query->execute();
    $result = $query->fetch();
    $nbArticles = (int) $result['nb_articles'];
    $parPage = 6;
    $pages = ceil($nbArticles / $parPage);
    $premier = ($currentPage * $parPage) - $parPage;
    $sql = 'SELECT * FROM nouvelle WHERE Diffusion = 0 OR Diffusion = 1 OR Diffusion = 2 ORDER BY IdNouvelle DESC LIMIT :premier, :parpage;';
    $query = $BDD->prepare($sql);
    $query->bindValue(':premier', $premier, PDO::PARAM_INT);
    $query->bindValue(':parpage', $parPage, PDO::PARAM_INT);
    $result = $query->execute();
}
    //la requete de la table page

//Si je suis Admin alors j'ai accès aux boutons pour ajouter une news
    ?>
    <div class="row justify-content-center justify-content-sm-start mt-5 margincustom col-10">
    <?php if (isset($_SESSION['User_Level']) && $_SESSION['User_Level'] > 1) {
        ?>
            <div class="col-12">
                <a href="page-ajoutnews"> <button id= <?php echo $idboutonsuccess; ?> type="submit" class="btn btn-success float-right lead"><?php echo $valueboutonsuccess; ?></button></a>
                </div>   
                <?php
    } ?>     

<?php
        //boucle les données récupérées
    while ($donnees = $query->fetch()) {
        //Mise du texte de la requête dans une variable
        $texte = $donnees['Texte'];
        //Remplacement des balises titres par des espaces pour l'affichage dans la "mininews"
        $texte = str_replace('</h1>', '    ', $texte);
        $texte = str_replace('</h2>', '    ', $texte);
        $texte = str_replace('</h3>', '    ', $texte);
        //Suppression de toutes les balises html
        $texte = strip_tags($texte);
        //Mise en variable de la donnée de l'ID de la news
        $idnews = $donnees['IdNouvelle'];
        //Suppression de toutes les balises html
        $titrenews = strip_tags($donnees['Titre']);
        //Si je n'ai pas de photos dans mon texte => affichage de la photo des news par défaut
        $fichiernews = $donnees['Fichier'];
        if ($fichiernews == ' ') {
            $fichiernews = $directory_img_upload.'defaut.png';
        }
        //Si la diffusion était 0 (admin) / 1 (tous) / 2 (membres) le message $bonus s'affichera comme cela
        if ($donnees['Diffusion'] == 0) {
            $bonus = '(News non publiée [Organisateur seulement])';
        } elseif ($donnees['Diffusion'] == 1) {
            $bonus = '(News grand public)';
        } else {
            $bonus = '(News pour les membres)';
        }
        //On inclus Newsmini pour l'affichage de l'aperçu de la news.
        include('./includes/template/newsmini.php');
    }
?>


<div class="row justify-content-center col-12">
                    <ul class="pagination">
                        <!-- Lien vers la page précédente (désactivé si on se trouve sur la 1ère page) -->
                        <li class="page-item <?= ($currentPage == 1) ? "disabled" : "" ?>">
                            <a href="./page-news-num-<?= $currentPage - 1 ?>" class="page-link">Précédente</a>
                        </li>
                        <?php for ($page = 1; $page <= $pages; $page++): ?>
                          <!-- Lien vers chacune des pages (activé si on se trouve sur la page correspondante) -->
                          <li class="page-item <?= ($currentPage == $page) ? "active" : "" ?>">
                                <a href="./page-news-num-<?= $page ?>" class="page-link"><?= $page ?></a>
                            </li>
                        <?php endfor ?>
                          <!-- Lien vers la page suivante (désactivé si on se trouve sur la dernière page) -->
                          <li class="page-item <?= ($currentPage == $pages) ? "disabled" : "" ?>">
                            <a href="./page-news-num-<?= $currentPage + 1 ?>" class="page-link">Suivante</a>
                        </li>
                    </ul>
                </div>
</div>