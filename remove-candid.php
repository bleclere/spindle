<?php

	$dbconnect = pg_connect("dbname=spindle port=5432 user=postgres password=postgres");

	$query = "DELETE FROM candidatures WHERE id=" . $_POST["id"];

	$result = pg_query($query);

	pg_free_result($result);
	pg_close($dbconnect);

?>