
<section class="py-0" id="forms-1">
    <div class="background-holder overlay overlay-0" style="background-image:url(./images/38.jpg);"></div>
    <!--/.background-holder-->
    <div class="container">
        <div class="row h-full align-items-center justify-content-center py-5">
            <div class="col-sm-10 col-md-8 col-lg-6 col-xl-5">
                <div class="tabs background-white radius-secondary pb-4">
                    <div class="tab-contents px-5">
                        <div class="tab-content active">
                            <form action="./index.php?page=<?php echo $mapage ?><?php echo isset($id) ? '&id='.$id : ''; ?>" method="post" class="register-form">
                                <h1 id="bandeau" class="lead bold h1 pb-4 text-center"><b><?php echo $titre ?></b></h1>
                                <input type="hidden" name="formulaire" value="<?php echo $action; ?>" />
                                <input type="hidden" name="IdAdherent" value="<?php echo isset($id) ? $id : ''; ?>" />
                                <div class="row text-center">
                                    <div class="col-lg-6">
                                        <label class="py-0 mb-0" for="name">Identifiant</label>
                                        <br /><input size="16" type="text" id="login" name="login" value="<?php echo isset($identifiant) ? $identifiant : '' ?>" placeholder="" required />
                                    </div>
                                    <div class="col-lg-6">
                                        <label class="py-0 mb-0"  for="name">Mot de passe</label>
                                        <br /><input size="16" type="password" id="password" name="password" value="<?php echo isset($password) ? $password : '' ?>" placeholder="" required />
                                    </div>
                                    <div class="col-lg-6">
                                        <label class="py-0 mb-0"  for="name">Prénom</label>
                                        <br /><input size="16" type="text" id="firstname" name="prenom" value="<?php echo isset($prenom) ? $prenom : '' ?>" placeholder="" required />
                                    </div>
                                    <div class="col-lg-6">
                                        <label class="py-0 mb-0"  for="name">Nom</label>
                                        <br /><input size="16" type="text" id="name" name="nom" value="<?php echo isset($nom) ? $nom : '' ?>" required />
                                    </div>
                                    <div class="col-lg-6">
                                        <label class="py-0 mb-0"  for="name">Date de naissance</label>
                                        <br /><input size="16" type="date" id="birth" name="dnaiss" value="<?php echo isset($datenaiss) ? $datenaiss : '' ?>" required />
                                    </div>
                                    <div class="col-lg-6">
                                        <label class="py-0 mb-0"  for="name">Adresse</label>
                                        <br /><input size="16" type="text" id="adress" name="adresse1" value="<?php echo isset($adresse) ? $adresse : '' ?>" required />
                                    </div>
                                    <div class="col-lg-6">
                                        <label class="py-0 mb-0"  for="cp">CP</label>
                                        <br /><input size="16" type="text" id="zip" name="cdpost" value="<?php echo isset($codep) ? $codep : '' ?>" required />
                                    </div>
                                    <div class="col-lg-6">
                                        <label class="py-0 mb-0"  for="name">Ville</label>
                                        <br /><input size="16" type="text" id="city" name="ville" value="<?php echo isset($ville) ? $ville : '' ?>" required />
                                    </div>
                                    <div class="col-lg-6">
                                        <label class="py-0 mb-0"  for="email">Email</label>
                                        <br /><input size="16" type="email" id="email" name="email" value="<?php echo isset($email) ? $email : '' ?>" required />
                                    </div>
                                    <div class="col-lg-6">
                                        <label class="py-0 mb-0"  for="mobile">Téléphone</label>
                                        <br /><input size="16" type="text" id="mobile" name="tel" value="<?php echo isset($tel) ? $tel : '' ?>" required />
                                    </div>
                                    <div class="col-lg-12">
                                        <label class="py-0 mb-0"  for="mobile">Votre cylindrée</label>
                                    </div>
                                    <div class="col-lg-12">
                                        <input type="radio" name="cc" value="125 cm3" <?php echo isset($cylindree) && $cylindree == "125 cm3" ? 'checked' : '';  ?>/>
                                        <label  for="mobile">125 cm3</label>
                                        <input type="radio" name="cc" value="250 cm3" <?php echo isset($cylindree) && $cylindree == "250 cm3" ? 'checked' : '';  ?>/>
                                        <label  for="mobile">250 cm3</label>
                                        <input type="radio" name="cc" value="> 250 cm3" <?php echo isset($cylindree) && $cylindree == "> 250 cm3" ? 'checked' : '';  ?>/>
                                        <label  for="mobile">> 250 cm3</label>
                                        <input type="radio" name="cc" value="aucune" <?php echo isset($cylindree) && $cylindree == "aucune" ? 'checked' : '';  ?>/>
                                        <label  for="mobile">aucune</label>
                                    </div>
                                    <div class="col-lg-12">
                                        <label class="py-0 mb-0"  for="mobile">En vous inscrivant, vous acceptez que votre image soit utilisée sur le site internet</label>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-success float-right lead"><?php echo $btn_register; ?></button>
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