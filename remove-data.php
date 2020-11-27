<?php

	$dbconnect = pg_connect("dbname=spindle port=5432 user=postgres password=postgres");

	if ($_POST["type"] == "candidature") {

		$query = "DELETE FROM candidatures WHERE id=" . $_POST["id"];

	} elseif ($_POST["type"] == "valorisation") {

		$query = "DELETE FROM valorisations WHERE id=" . $_POST["id"];

	} else {

		die("Type d’information non répertorié");

	}

	$result = pg_query($query);

	pg_free_result($result);
	pg_close($dbconnect);

?>