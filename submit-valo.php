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

	$query = "INSERT INTO valorisations(type, ref, projet_id) VALUES (" . $_POST["type"] . ", " . $_POST["ref"] . ", " . $_POST["projet_id"] . ")";

	$result = pg_query($query) or die ("Impossible d’ajouter la valorisation : " . pg_last_error());

	pg_free_result($result);
	pg_close($dbconnect);


?>