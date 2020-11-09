<?php

	// Enregistrement des données de valorisation

	require("includes/functions.php");

	$dbconnect = pg_connect("dbname=spindle port=5432 user=postgres password=postgres") or die("Connection impossible : " . pg_last_error());

	foreach($_POST as $key => $value) {
		if(empty($_POST[$key])) {
			$_POST[$key] = "NULL";
		} else {
			$_POST[$key] = pg_escape_literal($value);
		}
	}

	$query_id = "SELECT id FROM projets ORDER BY id DESC LIMIT 1";

	$result_id = pg_query($query_id) or die ("Impossible d’obtenir le numéro de projet : " . pg_last_error());

	$projet = pg_fetch_result($result_id, 0, 0);

	pg_free_result($result_id);

	$query = "INSERT INTO valorisations(type, ref, projet_id) VALUES (" . $_POST["type"] . ", " . $_POST["ref"] . ", " . $projet . ")";

	$result = pg_query($query) or die ("Impossible d’ajouter la valorisation : " . pg_last_error());

	pg_free_result($result);
	pg_close($dbconnect);


?>