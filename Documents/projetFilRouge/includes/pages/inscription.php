
<section class="py-0" id="forms-1">
    <div class="background-holder overlay overlay-0" style="background-image:url(./images/11.jpg);"></div>
    <!--/.background-holder-->
    <div class="container">
        <div class="row h-full align-items-center justify-content-center py-5">
            <div class="col-sm-10 col-md-8 col-lg-6 col-xl-5">
                <div class="tabs background-white radius-secondary pb-4">
                    <div class="tab-contents px-5">
                        <div class="tab-content active">
                            <form action="./index.php?page=inscription" method="post" class="register-form">
                                <h1 id="bandeau" class="lead bold h1 pb-4 text-center"><b>Inscription</b></h1>
                                <input type="hidden" name="formulaire" value="register" />
                                <div class="row text-center">
                                    <div class="col-lg-6">
                                        <label class="py-0 mb-0" for="name">Identifiant</label>
                                        <br /><input size="16" type="text" id="login" name="login" value="test identifiant" placeholder="" required />
                                    </div>
                                    <div class="col-lg-6">
                                        <label class="py-0 mb-0"  for="name">Mot de passe</label>
                                        <br /><input size="16" type="password" id="password" name="password" value="test password" placeholder="" required />
                                    </div>
                                    <div class="col-lg-6">
                                        <label class="py-0 mb-0"  for="name">Prénom</label>
                                        <br /><input size="16" type="text" id="firstname" name="prenom" value="test prenom" placeholder="" required />
                                    </div>
                                    <div class="col-lg-6">
                                        <label class="py-0 mb-0"  for="name">Nom</label>
                                        <br /><input size="16" type="text" id="name" name="nom" value="test nom" required />
                                    </div>
                                    <div class="col-lg-6">
                                        <label class="py-0 mb-0"  for="name">Date de naissance</label>
                                        <br /><input size="16" type="date" id="birth" name="dnaiss" value="1980-01-22" required />
                                    </div>
                                    <div class="col-lg-6">
                                        <label class="py-0 mb-0"  for="name">Adresse</label>
                                        <br /><input size="16" type="text" id="adress" name="adresse1" value="test adresse" required />
                                    </div>
                                    <div class="col-lg-6">
                                        <label class="py-0 mb-0"  for="cp">CP</label>
                                        <br /><input size="16" type="text" id="zip" name="cdpost" value="66200" required />
                                    </div>
                                    <div class="col-lg-6">
                                        <label class="py-0 mb-0"  for="name">Ville</label>
                                        <br /><input size="16" type="text" id="city" name="ville" value="test ville" required />
                                    </div>
                                    <div class="col-lg-6">
                                        <label class="py-0 mb-0"  for="email">Email</label>
                                        <br /><input size="16" type="email" id="email" name="email" value="test@test.com" required />
                                    </div>
                                    <div class="col-lg-6">
                                        <label class="py-0 mb-0"  for="mobile">Téléphone</label>
                                        <br /><input size="16" type="text" id="mobile" name="tel" value="test tel" required />
                                    </div>
                                    <div class="col-lg-12">
                                        <label class="py-0 mb-0"  for="mobile">Votre cylindrée</label>
                                    </div>
                                        <div class="col-lg-12">
                                            <input type="radio" name="cc" value="125 cm3" />
                                            <label  for="mobile">125 cm3</label>
                                            <input type="radio" name="cc" value="250 cm3" />
                                            <label  for="mobile">250 cm3</label>
                                            <input type="radio" name="cc" value="> 250 cm3" />
                                            <label  for="mobile">> 250 cm3</label>
                                            <input type="radio" name="cc" value="aucune" checked/>
                                            <label  for="mobile">aucune</label>
                                    </div>
                                    <div class="col-lg-12">
                                        <label class="py-0 mb-0"  for="mobile">En vous inscrivant, vous acceptez que votre image soit utilisée sur le site internet</label>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-success float-right lead">S'inscrire</button>
                            </form>
                        </div>
                        <div class="tab-content text-center" style="min-height: 325px;">
                            <div><img class="mb-4" src="./assets/images/icons/icon-paypal.svg" width="100" alt="paypal"></div><a class="btn btn-primary" href="#">Pay $299 with paypal</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/.row-->
    </div>
    <!--/.container-->
</section>