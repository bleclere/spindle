<!DOCTYPE html>
<html>
<head>
	<title>Modifier un projet</title>
	<meta charset="utf8">
	<link rel="stylesheet" type="text/css" href="includes/css/style.css">
</head>
<body onload="remplir();">

	<?php

		$id = 1;

	  	$dbconnect = pg_connect("dbname=spindle port=5432 user=postgres password=postgres") or die("Impossible de se connecter à la base de données : " . pg_last_error());

		$query = "SELECT * FROM projets WHERE id = " . $id;

		$result = pg_query($query) or die("Requête impossible : " . pg_last_error());

		$tab = pg_fetch_all($result)[0];

		pg_free_result($result);


		$query = "SELECT * FROM candidatures WHERE projet_id = " .$id;

		$result = pg_query($query) or die("Requête candidatures impossible : " . pg_last_error());

		$tab_candid = pg_fetch_all($result);

		//var_dump($tab_candid);

		pg_free_result($result);


		$query = "SELECT * FROM valorisations WHERE projet_id = " .$id;

		$result = pg_query($query);

		$tab_valo = pg_fetch_all($result);

		pg_free_result($result);

		pg_close($dbconnect);

		//var_dump($tab_valo);

	 ?>


	<h1>Modifier le projet <?=$tab["nom"];?></h1>


		<input type="hidden" name="id" value="<?=$id;?>">
		<p>Nom du projet (acronyme) : <input name="nom" type="text" value="<?=$tab["nom"];?>"></p>
		<p>Nom complet : <input name="nom_complet" type="text" size="105" value="<?=$tab["nom_complet"];?>"></p>
		<p>Date de demande : <input type="date" name="date" value="<?=$tab["date_demande"];?>"></p>
		<p>Porteur : <input type="text" name="porteur" value="<?=$tab["client"];?>"></p>
		<p>Service demandeur : <input type="text" name="service" list="service" value="<?=$tab["service"];?>"></p>
		<p>Financement :
			<input type="radio" name="financement" value="oui"> oui
			<input type="radio" name="financement" value="non"> non
		</p>
		<p>Chef de projet SPIn :
			<input type="radio" name="chefferie" value="oui" onchange="cond_cdp();"> oui
			<input type="radio" name="chefferie" value="non" onchange="cond_cdp();"> non
			<input type="radio" name="chefferie" value="ponctuel" onchange="cond_cdp();"> aide ponctuelle
		</p>
		<p id="cdp" style="display: none;">Autre chef de projet :
			<input type="radio" name="cdp" value="chu"> CHU
			<input type="radio" name="cdp" value="hors"> hors CHU
		</p>
		<p>Méthodologie :
			<input type="radio" name="methodologie" value="oui" onchange="cond_methodo();"> oui
			<input type="radio" name="methodologie" value="non" onchange="cond_methodo();"> non
		</p>
		<p>Analyse :
			<input type="radio" name="analyse" value="oui" onchange="cond_methodo();"> oui
			<input type="radio" name="analyse" value="non" onchange="cond_methodo();"> non
		</p>
		<p>Valorisation :
			<input type="radio" name="valorisation" value="oui"> oui
			<input type="radio" name="valorisation" value="non"> non
		</p>
		<p>Avancement :
			<input type="radio" name="avancement" value="reflexion" onchange="cond_cloture();"> <span id="g1">réflexion</span>
			<input type="radio" name="avancement" value="redaction" onchange="cond_cloture();"> <span id="g2">rédaction protocole/candidature</span>
			<input type="radio" name="avancement" value="soumis" onchange="cond_cloture();"> <span id="g3">soumis</span>
			<input type="radio" name="avancement" value="attente" onchange="cond_cloture();"> <span id="g4">en attente</span>
			<input type="radio" name="avancement" value="analyse" onchange="cond_cloture();"> <span id="g5">analyse</span>
			<input type="radio" name="avancement" value="valorisation" onchange="cond_cloture();"> <span id="g6">valorisation</span>
			<input type="radio" name="avancement" value="clos" onchange="cond_cloture();"> <span id="g7">clos</span>
		</p>
		<p id="cloture" style="display: none;">Date de clôture : <input type="date" name="date_cloture" value="<?=$tab["date_cloture"];?>"></p>
		<p id="methodo" style="display: none;">Methodologiste/Analyste : <input type="text" name="utilisateur" list="utilisateurs" value="<?=$tab["methodo"];?>"></p>
		<p>
			Résumé : <br>
			<textarea name="resume" cols="80" rows="10" ><?=$tab["resume"];?></textarea>
		</p>
		<div id="candidature"><p>Candidatures</p>
		<?php if ($tab_candid): ?>
			<?php foreach ($tab_candid as $candid): ?>
				<div>
					<span class="cross" onclick="remove_candidature(this);">X</span>
					<div style="display: inline-block;" class="candid_data">
						<input type="hidden" name="id" value="<?= $candid["id"] ?>">
						<p>AAP/AO : <input type="text" list="aap" name="aap" value="<?= $candid["aap"] ?>"></p>
						<p>Année : <input type="number" min="2020" max="2050" name="annee" value="<?= $candid["annee"];?>"></p>
						<p>Budget : <input type="number" name="budget" value=<?= $candid["budget"]?>> €</p>
						<p>Obtenu :
							<?php $obtenu = $candid["statut"] == "oui"; ?>
							<input type="radio" name="statut" value="oui" <?php if ($obtenu) echo "checked"; ?>> oui 
							<input type="radio" name="statut" value="non" <?php if (!$obtenu) echo "checked"; ?>> non 
						</p>
					</div>
				</div>
			<?php endforeach ?>
		<?php endif ?>
		<button type="button" onclick="add_candidature();" id="addcandidature">Ajouter une candidature</button>

		<div id="valorisation"><p>Valorisations</p></div>
		<?php if ($tab_valo): ?>
		<?php foreach ($tab_valo as $valo): ?>
			<div>
					<span class="cross" onclick="remove_candidature(this);">X</span>
					<div style="display: inline-block;" class="valo_data">
						<input type="hidden" name="id" value="<?= $valo["id"] ?>">
						<p>Référence : <input type="text" size="105" name="reference" value="<?= $candid["reference"] ?>"></p>
						<p>Type de valorisation :
							<?php foreach(['article', 'poster', 'communication orale'] as $type): ?>)
								<input type="radio" name="type" value="<?= $type ?>" <?php if ($valo["type"] == $type) echo "checked"; ?>> <?= $type ?>  
							<?php endforeach ?>
						</p>
					</div>
				</div>
		<?php endforeach ?>
		<?php endif ?>
		<button type="button" onclick="add_valo();" id="addvalo">Ajouter une valorisation
		</button>
		<p><button type="button" onclick="submit_data();">Modifier</button></p>

	<?php
		include("includes/datalists-projets.php");
	?>


<?php

		$dbconnect = pg_connect("dbname=spindle port=5432 user=postgres password=postgres") or die(" Connection impossible : " . pg_last_error());
		$query = "SELECT nom, prenom FROM utilisateurs WHERE statut = 'methodo' ORDER BY nom";

		$result = pg_query($query) or die("Requête incorrecte : " . pg_last_error());

		echo "<datalist id=\"utilisateurs\">";

		while($row = pg_fetch_row($result)) {
			echo "<option value=\"" . $row[0] . ", " . $row[1] . "\">";
		}

		echo "</datalist>";

		pg_free_result($result);
		pg_close($dbconnect);

?>


	<script>

	function remplir() {
		// sélectionner en fonction du résultat
		if ("<?=$tab["financement"];?>" == "oui") {
			document.getElementsByName("financement")[0].checked = true;
		} else if ("<?=$tab["financement"];?>" == "non") {
			document.getElementsByName("financement")[1].checked = true;
		}

		// sélectionner en fonction du résultat
		if ("<?=$tab["chefferie"];?>" == "oui") {
			document.getElementsByName("chefferie")[0].checked = true;
		} else if ("<?=$tab["chefferie"];?>" == "non") {
			document.getElementsByName("chefferie")[1].checked = true;
		} else if ("<?=$tab["chefferie"];?>" == "ponctuel") {
			document.getElementsByName("chefferie")[2].checked = true;
		}

		// sélectionner en fonction du résultat
		if ("<?=$tab["cdp"];?>" == "chu") {
			document.getElementsByName("cdp")[0].checked = true;
		} else if ("<?=$tab["cdp"];?>" == "hors") {
			document.getElementsByName("cdp")[1].checked = true;
		}

		// sélectionner en fonction du résultat
		if ("<?=$tab["methodologie"];?>" == "oui") {
			document.getElementsByName("methodologie")[0].checked = true;
		} else if ("<?=$tab["methodologie"];?>" == "non") {
			document.getElementsByName("methodologie")[1].checked = true;
		}


		// sélectionner en fonction du résultat
		if ("<?=$tab["analyser"];?>" == "oui") {
			document.getElementsByName("analyse")[0].checked = true;
		} else if ("<?=$tab["analyser"];?>" == "non") {
			document.getElementsByName("analyse")[1].checked = true;
		}


		// sélectionner en fonction du résultat
		if ("<?=$tab["valorisation"];?>" == "oui") {
			document.getElementsByName("valorisation")[0].checked = true;
		} else if ("<?=$tab["valorisation"];?>" == "non") {
			document.getElementsByName("valorisation")[1].checked = true;
		}

		// sélectionner en fonction du résultat
		if ("<?=$tab["avancement"];?>" == "reflexion") {
			document.getElementsByName("avancement")[0].checked = true;
		} else if ("<?=$tab["avancement"];?>" == "redaction") {
			document.getElementsByName("avancement")[1].checked = true;
		} else if ("<?=$tab["avancement"];?>" == "soumis") {
			document.getElementsByName("avancement")[2].checked = true;
		} else if ("<?=$tab["avancement"];?>" == "attente") {
			document.getElementsByName("avancement")[3].checked = true;
		} else if ("<?=$tab["avancement"];?>" == "analyse") {
			document.getElementsByName("avancement")[4].checked = true;
		} else if ("<?=$tab["avancement"];?>" == "valorisation") {
			document.getElementsByName("avancement")[5].checked = true;
		} else if ("<?=$tab["avancement"];?>" == "clos") {
			document.getElementsByName("avancement")[6].checked = true;
		}
	}

		function cond_methodo() {

			var condition = document.getElementsByName("methodologie")[0].checked || document.getElementsByName("analyse")[0].checked;

			if (condition) {
				document.getElementById("methodo").style.display = "inline";
			} else {
				document.getElementById("methodo").style.display = "none";
			}
		}

		function cond_cloture() {
			var condition = document.getElementsByName("avancement")[6].checked;

			if (condition) {
				document.getElementById("cloture").style.display = "inline";
			} else {
				document.getElementById("cloture").style.display = "none";
			}
		}

		function cond_cdp() {
			var condition = document.getElementsByName("chefferie")[1].checked;

			if (condition) {
				document.getElementById("cdp").style.display = "inline";
			} else {
				document.getElementById("cdp").style.display = "none";
			}

		}

		function remove_candidature(cross) {

			cross.parentNode.remove();
			
			const requete = new XMLHttpRequest();
			const data = new FormData();

			data.append("id", cross.parentNode.children[1].children["id"].value);

			requete.addEventListener('load', function(event) {
					alert('Données projet saisies.');
			});

			requete.addEventListener('error', function(event) {
				alert('something went wrong.');
			});

			requete.open('POST', 'remove-candid.php');
			requete.send(data);

		}

	</script>

</body>
</html>