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


	$query = "INSERT INTO candidatures(aap, budget, statut, projet_id, annee) VALUES (" . $_POST["aap"] . ", " . $_POST["budget"] . ", " . $_POST["statut"] . ", " . $_POST["projet_id"]
 . ", " . $_POST["annee"] . ")";


 	$result = pg_query($query) or die("Impossible d’ajouter la candidature : " . pg_last_error());

 	pg_free_result($result);
 	pg_close($dbconnect);

 	echo $_POST['projet_id'];
?>