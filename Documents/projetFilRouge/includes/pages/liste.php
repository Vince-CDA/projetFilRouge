<div class="col-12 pt-8">
	<div class="my-6"></div>
	<h4>Liste des membres</h4>
	<div class="my-4"></div>
	<div class="table-responsive">
		<table class="table table-striped">
			<thead>
				<tr>
					<th>
						Id
					</th>
					<th>
						Prénom
					</th>
					<th>
						Nom
					</th>
					<th>
						Pseudo
                    </th>
                    <th>
						Statut (<a href="./page-liste-<?php echo !isset($trie) || empty($trie) || $trie == 0 ? 'asc' : 'desc'; ?>">Trier</a>)
                    </th>
                    <th>
						Activer/Désactiver
                    </th>
                    <th>
						Editer
                    </th>
                    <th>
						Supprimer
					</th>
				</tr>
            </thead>
            <tbody>
<?php
            if (isset($_SESSION['User_Level']) && $_SESSION['User_Level'] > 1) {
                //lancement de la requete
                if (isset($_GET['action']) && !empty($_GET['action']) && $_GET['action'] == 'desc') {
                    $trie = 0;
                    $trie2 = 1;
                }else {
                    $trie = 1;
                    $trie2 = 0;
                }
                $listerequete = $BDD->query('SELECT * FROM adherent WHERE Active ='.$trie);
                $listerequete2 = $BDD->query('SELECT * FROM adherent WHERE Active ='.$trie2);
                while ($donnees = $listerequete->fetch()) {
                    $IdAdherent = $donnees['IdAdherent'];
                    $Prenom = $donnees['Prenom'];
                    $Nom = $donnees['Nom'];
                    $Login = $donnees['Login'];
                    $Active = $donnees['Active'];
                    $Statut = $Active == 1 ? 'Activé' : 'Désactivé'; 
                    $LienDesactiver = '<a href="./page-liste-'.$IdAdherent.'-desactive">Désactiver l\'adhérent</a>';
                    $LienActiver = '<a href="./page-liste-'.$IdAdherent.'-active">Activer l\'adhérent</a>';
                    $LienProfilId = '<a href="./page-profil-'.$IdAdherent.'">Profil de l\'adhérent</a>';
                    $LienDeleteAdherent = '<a href="./page-membres-'.$IdAdherent.'-delete">Supprimer l\'adhérent</a>';
                    include('./includes/template/listmembres.php');
                }
                while ($donnees = $listerequete2->fetch()) {
                    $IdAdherent = $donnees['IdAdherent'];
                    $Prenom = $donnees['Prenom'];
                    $Nom = $donnees['Nom'];
                    $Login = $donnees['Login'];
                    $Active = $donnees['Active'];
                    $Statut = $Active == 1 ? 'Activé' : 'Désactivé'; 
                    $LienDesactiver = '<a href="./page-liste-'.$IdAdherent.'-desactive">Désactiver l\'adhérent</a>';
                    $LienActiver = '<a href="./page-liste-'.$IdAdherent.'-active">Activer l\'adhérent</a>';
                    $LienProfilId = '<a href="./page-profil-'.$IdAdherent.'">Profil de l\'adhérent</a>';
                    $LienDeleteAdherent = '<a href="./page-membres-'.$IdAdherent.'-delete">Supprimer l\'adhérent</a>';
                    include('./includes/template/listmembres.php');
                }

            }
?>

            </tbody>
		</table>
	</div>
</div>
