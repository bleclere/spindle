<?php

	// Enregistrement des données de candidature

	require("includes/functions.php");

	$dbconnect = pg_connect("dbname=spindle port=5432 user=postgres password=postgres") or die("Connection impossible : " . pg_last_error());

	foreach($_POST as $key => $value) {
		if(empty($_POST[$key])) {
			$_POST[$key] = "NULL";
		} else {
			$_POST[$key] = pg_escape_literal($value);
		}
	}

	$query_uno = "SELECT id FROM projets ORDER BY id DESC LIMIT 1";

	$result_uno = pg_query($query_uno) or die("Impossible d’obtenir de numéro de projet : " . pg_last_error());

	$projet = pg_fetch_result($result_uno, 0, 0);

	$query_duo = "INSERT INTO candidatures(aap, budget, statut, projet_id, annee) VALUES (" . $_POST["aap"] . ", " . $_POST["budget"] . ", " . $_POST["statut"] . ", " . $projet
 . ", " . $_POST["annee"] . ")";

 	pg_free_result($result_uno); 

 	$result_duo = pg_query($query_duo) or die("Impossible d’ajouter la candidature : " . pg_last_error());

 	pg_free_result($result_duo);
 	pg_close($dbconnect);
?>