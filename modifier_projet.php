<!DOCTYPE html>
<html>
<head>
	<title>Modifier un projet</title>
	<meta charset="utf8">
	<link rel="stylesheet" type="text/css" href="includes/css/style.css">
	<script type="text/javascript" src="includes/functions.js"></script>
</head>
<body>

	<?php

		require("includes/functions.php");

		// placeholder for study id queried.
		$id = 1;

		// récupération des données de projet
		$tab = query("SELECT * FROM projets WHERE id = " . $id)[0];

		// récupération des données de candidature
		$tab_candid = query("SELECT * FROM candidatures WHERE projet_id = " .$id);

		// récupération des données de valorisation
		$tab_valo = query("SELECT * FROM valorisations WHERE projet_id = " .$id);


	 ?>


	<h1>Modifier le projet <?=$tab["nom"];?></h1>

	<input type="hidden" name="id">
	<?php require("templates/projet.php"); ?>

	<script>
		
		document.getElementsByName("id")[0].value = <?=$id;?>;
		document.getElementsByName("nom")[0].value = "<?=$tab["nom"];?>";
		document.getElementsByName("nom_complet")[0].value = "<?=$tab["nom_complet"];?>";
		document.getElementsByName("date")[0].value = "<?=$tab["date_demande"];?>";
		document.getElementsByName("porteur")[0].value = "<?=$tab["client"];?>";
		document.getElementsByName("service")[0].value = "<?=$tab["service"];?>";
		document.getElementsByName("date_cloture")[0].value = "<?=$tab["date_cloture"];?>";
		document.getElementsByName("utilisateur")[0].value = "<?=$tab["methodo"];?>";
		document.getElementsByName("resume")[0]
				.append(document.createTextNode("<?=$tab["resume"];?>"));


		function remplir(name, key) {
			let objet = document.getElementsByName(name);
			for (let index=0; index < objet.length; index++) {
				if (objet[index].value === key) {
					objet[index].checked = true;
					break;
				}
			}
		}

		remplir("financement", "<?=$tab["financement"];?>");
		remplir("chefferie", "<?=$tab["chefferie"];?>");
		remplir("cdp", "<?=$tab["cdp"];?>");
		remplir("methodologie", "<?=$tab["methodologie"];?>");
		remplir("analyse", "<?=$tab["analyser"];?>");
		remplir("valorisation", "<?=$tab["valorisation"];?>");
		remplir("avancement", "<?=$tab["avancement"];?>");

		cond_cdp();
		cond_cloture();
		cond_methodo();

	</script>

		<div id="candidature"><p>Candidatures</p>
		<?php if ($tab_candid): ?>
			<?php foreach ($tab_candid as $candid): ?>
				<div>
					<span class="cross" onclick="remove_data(this);">X</span>
					<div style="display: inline-block;" class="candid_data">
						<input type="hidden" name="id" value="<?= $candid["id"] ?>">
						<p>AAP/AO : <input type="text" list="aap" name="aap" value="<?= $candid["aap"] ?>"></p>
						<p>Année : <input type="number" min="2020" max="2050" name="annee" value="<?= $candid["annee"];?>"></p>
						<p>Budget : <input type="number" name="budget" value=<?= $candid["budget"]?>> €</p>
						<p>Obtenu :
							<?php $obtenu = $candid["statut"] == "oui"; ?>
							<input type="radio" class="statut" value="oui" <?php if ($candid["statut"] == "oui") echo "checked"; ?>> oui 
							<input type="radio" class="statut" value="non" <?php if ($candid["statut"] == "non") echo "checked"; ?>> non 
						</p>
					</div>
				</div>
			<?php endforeach ?>
		<?php endif ?>
		<button type="button" onclick="add_candidature();" id="addcandidature">Ajouter une candidature</button>
		</div>

		<div id="valorisation"><p>Valorisations</p>
		<?php if ($tab_valo): ?>
		<?php foreach ($tab_valo as $valo): ?>
			<div>
					<span class="cross" onclick="remove_data(this);">X</span>
					<div style="display: inline-block;" class="valo_data">
						<input type="hidden" name="id" value="<?= $valo["id"] ?>">
						<p>Référence : <input type="text" size="105" name="reference" value="<?= $valo["ref"] ?>"></p>
						<p>Type de valorisation :
							<?php foreach(['article', 'poster', 'communication orale'] as $type): ?>
								<input type="radio" class="type" value="<?= $type ?>" <?php if ($valo["type"] == $type) echo "checked"; ?>> <?= $type ?>  
							<?php endforeach ?>
						</p>
					</div>
				</div>
		<?php endforeach ?>
		<?php endif ?>
		<button type="button" onclick="add_valo();" id="addvalo">Ajouter une valorisation
		</button>
		</div>

		<p><button type="button" onclick="submit_data();">Modifier</button></p>

	<?php 

	include("includes/datalists-projets.php"); 
	create_datalist();

	?>

	<script>

		function remove_data(cross) {
			
			const requete = new XMLHttpRequest();
			const data = new FormData();

			data.append("id", cross.parentNode.children[1].children["id"].value);
			data.append("type", cross.parentNode.parentNode.id);

			/*console.log(cross.parentNode.children[1].children["id"].value);
			console.log(cross.parentNode.parentNode.id);*/
			/*requete.addEventListener('load', function(event) {
					alert('Données projet saisies.');
			});

			requete.addEventListener('error', function(event) {
				alert('something went wrong.');
			});*/


			requete.open('POST', 'remove-data.php');
			requete.send(data);

			cross.parentNode.remove();

		}


		function remove_valo(cross) {

		}

	</script>

</body>
</html>