            <!-- Affichage d'un membre dans la page des membres avec Prénom Nom en lien vers sa page profil avec son id, Possibilté de suppression du membre si userlevel > 1 (Admin) -->
<div class="membre col-sm-6 col-lg-4 mb-lg-0 ">
    <div class="border border-2x radius-secondary border-color-10 py-4 mb-4">
        <img id="blah" class="radius-round" src="<?php echo isset($Donnees['Avatar']) && !empty($Donnees['Avatar']) ? $directory_img_upload.$Donnees['Avatar'] : $directory_img_upload.$defautimg; ?>" alt="Member" >
        <h4 class="color-3 mt-3 mb-2"><a href="page-profil-<?php echo $Donnees['IdAdherent']; ?>"><?php echo $Donnees['Prenom'].' '.$Donnees['Nom']; ?></a></h4>
        <h6 class="color-7 mb-4"><?php echo $Donnees['CC']; ?></h6><?php if (isset($_SESSION['User_Level']) && $_SESSION['User_Level'] > 1) {
    ?><a class="btn-icon-pop fs--1 fw-600" href="page-membres-delete-<?php echo $Donnees['IdAdherent']; ?>"><span class="fa fa-remove mr-2" data-fa-transform="grow-10"></span>Supprimer ce membre</a><?php
} ?>
        <a href="" class="aproposmembre btn btn-success btn-sm"  data-idA= <?php echo $Donnees['IdAdherent']; ?> >En savoir plus</a>
    </div>
</div>