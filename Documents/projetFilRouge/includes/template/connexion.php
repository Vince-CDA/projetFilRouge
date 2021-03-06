
<?php
//Voici le template de connexion avec $Titre initialisé
?>
<section class="py-0" id="forms-1">
    <div class="background-holder overlay overlay-0" style="background-image:url(./images/38.jpg);"></div>
    <!--/.background-holder-->
    <div class="container">
        <div class="row h-full align-items-center justify-content-center py-5">
            <div class="col-sm-10 col-md-8 col-lg-6 col-xl-5">
                <div class="tabs background-white radius-secondary pb-4">
                    <div class="tab-contents px-5">
                        <div class="tab-content active">
                            <form action="page-connexion" method="post">
                                <input type="hidden" name="formulaire" value="connexion" />
                                <h1 id="bandeau" class="lead bold h1 pb-4 text-center"><b><?php echo $Titre ?></b></h1>
                                <div class="row text-center">
                                    <div class="col-lg-6">
                                        <label class="py-0 mb-0" for="name">Identifiant</label>
                                        <br /><input size="16" type="text" id="login" name="Login" placeholder="" value="UtilisateurTest1" required />
                                    </div>
                                    <div class="col-lg-6">
                                        <label class="py-0 mb-0"  for="name">Mot de passe</label>
                                        <br /><input size="16" type="password" id="password" name="Password" placeholder="" value="123456Test" required />
                                    </div>
                                    <div class="col-lg-12">
                                        <label class="py-0 mb-0"  for="mobile">Veuillez saisir votre identifiant et votre mot de passe<br />(ATTENTION, Fil Rouge en cours <br /> il manque un caractère dans le mot de passe <br /> Veuillez lire le message Teams pour le récupérer...)</label>
                                    </div>
                                </div>
                                <div class="g-recaptcha col-12" data-sitekey="6LfVpssZAAAAALskuUcMWYxfZ-WYY2hOxIJi4cxr"></div>
                                <button type="submit" class="btn btn-success float-right lead">Connexion</button>
                                <label class="py-0 mt-2 mb-0 lead"  for="mobile"><a href="./page-connexion-mdpoublie">Mot de passe oublié ?</label></a>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/.row-->
    </div>
    <!--/.container-->
</section>

<!--
-->