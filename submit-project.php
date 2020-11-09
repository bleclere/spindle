<?php
	require("includes/functions.php");

	// Enregistrement du projet

	// Valeurs par défaut pour données manquantes :
	// --------------------------------------------


	$dbconnect = pg_connect("dbname=spindle user=postgres password=postgres port=5432") or die("Connection impossible : " . pg_last_error());

	// Certaines valeurs peuvent ne pas être avoir été remplies : mettre la valeur null dans ce cas. Les autres doivent être échappées (caractères non autorisés)
	$echappe = ["porteur", "service", "resume", "nom", "nom_complet", "methodologie", "financement", "avancement", "chefferie", "valorisation", "analyse", "cdp", "utilisateur"];

	foreach($echappe as $value) {
		if (empty($_POST[$value])) {
			$_POST[$value] = "NULL";
		} else {
			$_POST[$value] = pg_escape_literal($_POST[$value]);
		}
	}

	// Traitement des dates
	$date = ["date", "date_cloture"];

	foreach($date as $variable) {
		if ($_POST[$variable] == "") {
			$_POST[$variable] = "NULL";
		} else {
			$_POST[$variable] = "TO_DATE('" . $_POST[$variable] . "', 'YYYY/MM/DD')";
		}
	}


	$query = "INSERT INTO projets(date_demande, client, service, methodologie, resume, financement, avancement, date_cloture, nom, nom_complet, chefferie, valorisation, analyser, cdp, methodo) VALUES (" . $_POST["date"] . ", " . $_POST["porteur"] . ", " . $_POST["service"] . ", " . $_POST["methodologie"] . ", " . $_POST["resume"] . ", " . $_POST["financement"] . ", " . $_POST["avancement"] . ", " . $_POST["date_cloture"] . ", " . $_POST["nom"] . ", " . $_POST["nom_complet"] . ", " . $_POST["chefferie"] . ", " . $_POST["valorisation"] . ", " . $_POST["analyse"] . ", " . $_POST["cdp"] . ", " . $_POST["utilisateur"] . ")";
	//var_dump($query);


	$result = pg_query($query) or die("requete impossible : " . pg_last_error());
	//print_r($result);

	pg_free_result($result);


	$query_id = "SELECT id FROM projets ORDER BY id DESC LIMIT 1";

	$result_id = pg_query($query_id) or die("Impossible de récupérer l’id : " . pg_last_error());

	$id = pg_fetch_result($result_id, 0, 0);

	echo "$id";

	pg_close($dbconnect);


?>
