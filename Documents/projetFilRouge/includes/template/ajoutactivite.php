
<main>
    <section id="contact-5">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-6 text-center">
            <h2><?php echo $Titre ?></h2>
          </div>
          <div class="col-md-4 mt-4">
                <input class="form-group" type="checkbox" name="diffusion" value="1"/><label class="ls text-uppercase color-3 fw-700 mb-0 ml-1">Rendre public</label>
                </div>    
          <div class="col-lg-12 mt-4">
              <div class="row justify-content-center">
              <div class="col-md-12">
              <input type="hidden" name="IdAdherent" value="<?php echo $_SESSION['Id'];?>" required="required">
                </div>
                <div class="col-md-12">
                  <div class="form-group"><label class="ls text-uppercase color-3 fw-700 mb-0">Initulé d'activité</label><input class="form-control background-white" type="text" name="IntituleActivite" required="required"></div>
                </div>
                <div class="col-md-4">
                  <div class="form-group"><label class="ls text-uppercase color-3 fw-700 mb-0">Date de début d'activité</label><input class="form-control background-white" type="datetime-local" name="DDebut" required="required"></div>
                </div>
                <div class="col-md-4">
                  <div class="form-group"><label class="ls text-uppercase color-3 fw-700 mb-0">Date de fin d'activité</label><input class="form-control background-white" type="datetime-local" name="DFin" required="required"></div>
                </div>
                <div class="col-md-4">
                  <div class="form-group"><label class="ls text-uppercase color-3 fw-700 mb-0">Date limite d'inscription</label><input class="form-control background-white" type="datetime-local" name="DLimite" required="required"></div>
                </div>
                <div class="col-md-4">
                  <div class="form-group"><label class="ls text-uppercase color-3 fw-700 mb-0">Tarif adhérent en €</label><input class="form-control background-white" type="number" name="TarifAdherent" min="0" max="250" required="required"></div>
                </div>
                <div class="col-md-4">
                  <div class="form-group"><label class="ls text-uppercase color-3 fw-700 mb-0">Tarif invité en €</label><input class="form-control background-white" type="number" name="TarifInvite" min="0" max="250" required="required"></div>
                </div>
                <div class="col-md-4">
                <div class="form-group"><label class="ls text-uppercase color-3 fw-700 mb-0">
                <select name="IdType" id="IdType">
                    <?php
                    //la requete
                    $Reponse = $BDD->query('SELECT * FROM type_activite');
                    //boucle les données récupérées
                    while ($Donnees = $Reponse->fetch()) { ?>
                    <option value="<?php echo $Donnees['IdType']; ?>"><?php echo $Donnees['IntituleType']; ?></option>
                    <?php } ?>
                    </select>
                </div>
                </div>

                <div class="col-12">
                  <div id="editor"  class="form-group"><label class="ls text-uppercase color-3 fw-700 mb-0">Description de l'activité</label><textarea class="form-control background-white" rows="8" name="Description"></textarea></div>
                </div>
                <div class="row">
                                        <div class="col-12  mt-2">
                                        <button id="<?php echo $idboutonsuccess; ?>" type="submit" class="btn btn-success float-right lead"><?php echo $valueboutonsuccess; ?></button>
                                                                                <a href="page-news"><button id="annnuler" type="submit" class="btn btn-danger float-right lead">Annuler</button></a>
                                                                            
                                        </div>
                                </div>
              </div>
              <div class="zform-feedback mt-3"></div>
          </div>
        </div>
        <!--/.row-->
      </div>
      <!--/.container-->
    </section>
  </main><!--  -->