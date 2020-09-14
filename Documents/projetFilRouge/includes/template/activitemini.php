            <!-- Affichage de mini carte de news avec image : lien vers le contenu de la news via son ID -->

            <div class="card h-100 col-3 m-6 ml-5"><a class="overflow-hidden" href="page-newscontent-<?php echo $idactivite; ?> "><img class="card-img-top mt-3" src="<?php echo $fichieractivite; ?>" alt="Card image cap"></a>
              <div class="card-block"><a class="color-1" href="page-activite-<?php echo $idactivite; ?> ">
                  <h5 class="fw-400 d-inline-block mb-3"><?php echo $titreactivite; ?></h5>
                </a>
                <p class="card-text">Date de début : <?php echo strftime("%A %d %B %Y à %X", strtotime($date)); ?></p>  

                <p class="card-text"><?php echo substr($texte, 0, 300).' [...]'; ?><a class="btn btn-link mt-6" href="page-<?php echo $pagename; ?>-<?php echo $idactivite; ?> "><?php echo $liensuite;?></a>
            </div>
            </div>
