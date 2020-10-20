<!DOCTYPE html>
<html>
<head>
	<title>Créer un projet</title>
	<meta charset="utf8">
	<link rel="stylesheet" type="text/css" href="templates/css/style.css">
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
		<input type="submit" value="Soumettre">
	</form>


	<datalist id="service">
		<option value="PHU 1"></option>
		<option value="PHU 2"></option>
		<option value="PHU 3"></option>
		<option value="PHU 4"></option>
		<option value="PHU 5"></option>
		<option value="PHU 6"></option>
		<option value="PHU 7"></option>
		<option value="PHU 8"></option>
		<option value="PHU 9"></option>
		<option value="PHU 10"></option>
		<option value="PHU 11"></option>
		<option value="PHU 12"></option>
	</datalist>


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

	</script>

</body>
</html>
