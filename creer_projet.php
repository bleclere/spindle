<!DOCTYPE html>
<html>
<head>
	<title>Créer un projet</title>
	<meta charset="utf8">
	<link rel="stylesheet" type="text/css" href="includes/css/style.css">
</head>
<body>

	<h1>Créer un projet</h1>


	<form action="submit-project.php" method="post">

		<p>Nom du projet (acronyme) : <input name="nom" type="text"></p>
		<p>Nom complet : <input name="nom_complet" type="text" size="105"></p>
		<p>Date de demande : <input type="date" name="date"></p>
		<p>Porteur : <input type="text" name="porteur"></p>
		<p>Service demandeur : <input type="text" name="service" list="service"></p>
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
		<p id="cloture" style="display: none;">Date de clôture : <input type="date" name="date_cloture"></p>
		<p id="methodo" style="display: none;">Methodologiste/Analyste : <input type="text" name="utilisateur" list="utilisateurs"></p>
		<p>
			Résumé : <br>
			<textarea name="resume" cols="80" rows="10"></textarea>
		</p>
		<div id="candidature"><p>Candidatures</p></div>
		<button type="button" onclick="add_candidature();" id="addcandidature">Ajouter une candidature</button>
		<div id="valorisation"><p>Valorisations</p></div>
		<button type="button" onclick="add_valo();" id="addvalo">Ajouter une valorisation
		</button>
		<p><input type="submit" value="Soumettre" onclick="return check_entry();"></p>
	</form>


	<?php 

	include("includes/datalists-projets.php");

	?>

<?php
		// Créer la datalist des utilisateurs pour le menu déroulant
		// ----------------------------------------------------------


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

		// faire apparaître un champ conditionnellement pour la saisie du méthodologiste
		function cond_methodo() {

			var condition = document.getElementsByName("methodologie")[0].checked || document.getElementsByName("analyse")[0].checked;

			if (condition) {
				document.getElementById("methodo").style.display = "inline";
			} else {
				document.getElementById("methodo").style.display = "none";
			}
		}

		// faire apparaître conditionnellement un champ pour la date de clôture
		function cond_cloture() {
			var condition = document.getElementsByName("avancement")[6].checked;

			if (condition) {
				document.getElementById("cloture").style.display = "inline";
			} else {
				document.getElementById("cloture").style.display = "none";
			}
		}

		// faire apparaître conditionnellement un champ pour le CdP
		function cond_cdp() {
			var condition = document.getElementsByName("chefferie")[1].checked;

			if (condition) {
				document.getElementById("cdp").style.display = "inline";
			} else {
				document.getElementById("cdp").style.display = "none";
			}

		}


		// vérifier qu’au moins un nom d’étude est fourni
		function check_entry() {
			if (document.getElementsByName("nom")[0].value.length == 0) {
				alert("Saisir au moins un nom de projet");
				return false;
			} else {
				return true;
			}
		}


		// faire apparaître les champs liés à la candidature
		function add_candidature() {

			var element = document.getElementById("candidature");

			//var index = element.getElementsByTagName("div").length + 1;
			var line = document.createElement("div");


			var cross = document.createElement("span");
			cross.appendChild(document.createTextNode("X"));
			cross.className = "cross";
			cross.onclick = function() {
				this.parentNode.remove();
			};
			line.appendChild(cross);


			var data_block = document.createElement("div");
			data_block.style.display = "inline-block";

			
			var aap = document.createElement("p");
			aap.appendChild(document.createTextNode("AAP/AO : "));
			var aap_input = document.createElement("input");
			aap_input.type = "text";
			var list = document.getElementById('aap').id;
  			aap_input.setAttribute('list', list);
			aap_input.name = "aap";
			aap.appendChild(aap_input);


			var annee = document.createElement("p");
			annee.appendChild(document.createTextNode("Année : "));
			var annee_input = document.createElement("input");
			annee_input.type = "number";
			annee_input.name = "annee";
			annee_input.min = "2020";
			annee_input.max = "2050";
			annee.appendChild(annee_input);

			var budget = document.createElement("p");
			budget.appendChild(document.createTextNode("Budget : "));
			var budget_input = document.createElement("input");
			budget_input.type = "number";
			budget_input.name = "budget";
			budget.appendChild(budget_input);
			budget.appendChild(document.createTextNode(" €"));

			var statut = document.createElement("p");
			statut.appendChild(document.createTextNode("Obtenu : "));
			var list_statut = ["oui", "non"];
			list_statut.forEach(function(x) {
				var statut_input = document.createElement("input");
				statut_input.name = "type_valo";
				statut_input.type = "radio";
				statut_input.value = x;
				statut.appendChild(statut_input);
				statut.appendChild(document.createTextNode(" " + x + " "));
			});

			data_block.appendChild(aap);
			data_block.appendChild(annee);
			data_block.appendChild(budget);
			data_block.appendChild(statut);

			line.appendChild(data_block);

			element.appendChild(line);
		}

		function add_valo() {


			var element = document.getElementById("valorisation");

			var line = document.createElement("div");


			var cross = document.createElement("span");
			cross.appendChild(document.createTextNode("X"));
			cross.className = "cross";
			cross.onclick = function() {
				this.parentNode.remove();
			};
			line.appendChild(cross);

			var data_block = document.createElement("div");
			data_block.style.display = "inline-block";

			var ref = document.createElement("p");
			ref.appendChild(document.createTextNode("Référence : "));
			var ref_input = document.createElement("input");
			ref_input.type = "text";
			ref_input.name = "reference";
			ref_input.size = 105;

			ref.appendChild(ref_input);


			var type = document.createElement("p");
			type.appendChild(document.createTextNode("Type de valorisation :"));
			var list_type = ["article", "poster", "communication orale"];
			list_type.forEach(function(x) {
				var type_input = document.createElement("input");
				type_input.name = "statut";
				type_input.type = "radio";
				type_input.value = x;
				type.appendChild(type_input);
				type.appendChild(document.createTextNode(" " + x + " "));
			});

			data_block.appendChild(type);
			data_block.appendChild(ref);

			line.appendChild(data_block);

			element.appendChild(line);
		}



	</script>

</body>
</html>
