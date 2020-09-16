<main>
            <!-- Template de news avec un bouton rouge et un vert pour supprimer ou modifier la news 
                Affichage du titre et du contenu de la news  -->
        <section class="background-11" id="content-6">
        <div class="container">
            <div class="row justify-content-center">
              <?php if (isset($_SESSION['User_Level']) && $_SESSION['User_Level'] > 1) { ?>
            <div class="col-12">
                <a href="page-editactivite-<?php echo $_GET['id'] ?>"> <button id= <?php echo $idboutonedit; ?> type="submit" class="btn btn-success float-right lead"><?php echo $valueboutonedit; ?></button></a>
                <a href="page-activite-<?php echo $_GET['id'] ?>-supprimer"> <button id= <?php echo $idboutondanger; ?> type="submit" class="btn btn-danger float-right lead"><?php echo $valueboutondanger; ?></button></a>
            </div>
              <?php } ?>
            <div class="col-lg-12">
                <h3 class="mb-4"><?php echo $titreactivite; ?></h3>
                <?php echo $contenuactivite; ?>
            </div>
            <div class="col-12 mt-4 mb-4">
              <div class="row justify-content-center zform p-3 p-md-6 background-11 radius-secondary border color-3 mb-3 ">
                <div class="col-md-4">
                  <div class="form-group"><label class="ls text-uppercase color-3 fw-700 mb-0">Date de début d'activité</label> :<br>  <?php echo strftime("%A %d %B %Y à %X", strtotime($datedebut)); ?></div>
                </div>
                <div class="col-md-4">
                  <div class="form-group"><label class="ls text-uppercase color-3 fw-700 mb-0">Date de fin d'activité</label> :<br>  <?php echo strftime("%A %d %B %Y à %X", strtotime($datefin)); ?></div>
                </div>
                <div class="col-md-4">
                  <div class="form-group"><label class="ls text-uppercase color-3 fw-700 mb-0">Date limite d'inscription</label> :<br>  <?php echo strftime("%A %d %B %Y à %X", strtotime($datelimite)); ?></div>
                </div>
                <div class="col-md-4">
                  <div class="form-group"><div class="form-group"><label class="ls text-uppercase color-3 fw-700 mb-0">Type d'activité</label> :  <?php echo $type; ?></div>
                </div>
                <div class="col-12">
                  <div class="form-group"><label class="ls text-uppercase color-3 fw-700 mb-0">Tarif adhérent</label> :  <?php echo $tarifa; ?> €</div>
                </div>
                <div class="col-12">
                  <div class="form-group"><label class="ls text-uppercase color-3 fw-700 mb-0">Tarif invité</label> :  <?php echo $tarifi; ?> €</div>
                </div>
                <div class="col-12">
                <a href="page-activitecontent-<?php echo $_GET['id'] ?>-1"> <button id= <?php echo $idboutonsuccess; ?> type="submit" class="btn btn-success "><?php echo $valueboutonsuccess; ?></button></a>
              </div>
                </div>
                </div>
                </div>
                

    </div>
        <!--/.row-->
    </div>
        <!--/.container-->
   