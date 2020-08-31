      <main>
            <!-- Template de news avec un bouton rouge et un vert pour supprimer ou modifier la news 
                Affichage du titre et du contenu de la news  -->
        <section class="background-11" id="content-6">
        <div class="container">
            <div class="row justify-content-center">
            <div class="col-12">
                <a href="./index.php?page=editnews&id=<?php echo $_GET['id'] ?>"> <button id= <?php echo $idboutonsuccess; ?> type="submit" class="btn btn-success float-right lead"><?php echo $valueboutonsuccess; ?></button></a>
                <a href="./index.php?page=news&id=<?php echo $_GET['id'] ?>&action=supprimer"> <button id= <?php echo $idboutondanger; ?> type="submit" class="btn btn-danger float-right lead"><?php echo $valueboutondanger; ?></button></a>
                </form>
            </div>
            <div class="col-lg-10">
                <h3 class="mb-4"><?php echo $titlenews; ?></h3>
                <?php echo $contenunews; ?>
            </div>

    </div>
        <!--/.row-->
    </div>
        <!--/.container-->
