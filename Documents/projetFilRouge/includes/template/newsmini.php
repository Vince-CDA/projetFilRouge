            <!-- Affichage de mini carte de news avec image : lien vers le contenu de la news via son ID -->

<div class="<?php echo isset($bonus) ? 'card-ombre' : ''; ?> card h-100 col-sm-12 col-lg-12 col-md-12 col-xl-4 mb-3"><a class="overflow-hidden" href="page-newscontent-<?php echo $idnews; ?> "><img class="card-img-top mt-3" src="<?php echo $fichiernews; ?>" alt="Card image cap"></a>
              <div class="card-block"><a class="color-1" href="page-newscontent-<?php echo $idnews; ?> ">
                  <h5 class="fw-400 d-inline-block mb-3"><?php echo '<h1>'.$titrenews.'</h1>'; echo isset($bonus) ? ' <h2>(News non publiée)</h2>' : '';; ?></h5>
                </a>
                <div class="col-12">
                <p class="card-text"><?php echo substr($texte, 0, 150).'...<br>'; ?><a class="btn btn-success col-12 mt-4" href="page-<?php echo $pagename; ?>-<?php echo $idnews; ?> "><?php echo $liensuite;?></a>
              </div>
              </div>
            </div>
