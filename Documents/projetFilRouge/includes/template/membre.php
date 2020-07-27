<div class="col-sm-6 col-lg-4 mb-lg-0 mb-4">
    <div class="border border-2x radius-secondary border-color-10 py-4"><img class="radius-round" src="./images/portraits/square/04.jpg" alt="Member" width="120">
        <h4 class="color-3 mt-3 mb-2"><a href="./index.php?page=profil&id=<?php echo $Donnees['IdAdherent']; ?>"><?php echo $Donnees['Prenom'].' '.$Donnees['Nom']; ?></a></h4>
        <h6 class="color-7 mb-4"><?php echo $Donnees['CC']; ?></h6><?php if(isset($_SESSION['User_Level']) && $_SESSION['User_Level'] > 1 ){ ?><a class="btn-icon-pop fs--1 fw-600" href="./index.php?page=membres&action=delete&id=<?php echo $Donnees['IdAdherent']; ?>"><span class="fa fa-remove mr-2" data-fa-transform="grow-10"></span>Supprimer ce membre</a><?php } ?>
    </div>
</div>