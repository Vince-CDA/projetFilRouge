            <!-- Affichage de mini carte de news avec image : lien vers le contenu de la news via son ID -->

<div class="card h-100 col-3 m-6 ml-5"><a class="overflow-hidden" href="./index.php?page=newscontent&id=<?php echo $donnees['IdNouvelle']; ?> "><img class="card-img-top mt-3" src="<?php echo $donnees['Fichier']; ?>" alt="Card image cap"></a>
              <div class="card-block"><a class="color-1" href="./index.php?page=newscontent&id=<?php echo $donnees['IdNouvelle']; ?> ">
                  <h5 class="fw-400 d-inline-block mb-3"><?php echo $donnees['Titre']; ?></h5>
                </a>
                <p class="card-text"><?php echo substr($texte,0,300).' [...]'; ?><a class="btn btn-link mt-5 ml-10 pl-0 pb-0" href="./index.php?page=newscontent&id=<?php echo $donnees['IdNouvelle']; ?> ">Lire la suite</a>
              </div>
            </div>
