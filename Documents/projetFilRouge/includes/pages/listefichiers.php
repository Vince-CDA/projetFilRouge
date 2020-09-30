<div class="col-12 pt-8">
	<div class="my-6"></div>
	<h4>Liste des fichiers</h4>
	<?php include('./includes/template/uploadfichier.php'); ?>
	
	<div class="my-4"></div>
	<div class="table-responsive">
		<table class="table table-striped">
			<thead>
				<tr>
					<th>
						Fichier
					</th>
					<th>
						Nom
					</th>
                    <th>
						Date
                    </th>
                    <th>
						Supprimer
					</th>
				</tr>
            </thead>
            <tbody>
<?php

$query = 'SELECT * FROM fichiers';
$listerequete = $BDD->query($query);
                while ($donnees = $listerequete->fetch()) {
                    $nomfichier = $donnees['Intitule'];
                    $datefichier = $donnees['Date'];
                    $fichiername = '<a href="'.$directory_img_fichier.$donnees['Fichier'].'" target="_blank">Consulter</a>';
                    $liensupprimerfichier = '<a href="./page-listefichiers-'.$donnees['IdFichier'].'-delete">Supprimer</a>';
                    include('./includes/template/listefichiers.php');
                }


?>

            </tbody>
		</table>
	</div>
</div>
