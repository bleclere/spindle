<!DOCTYPE html>
<html>
<head>
	<title>Index</title>
	<meta charset="utf8">
</head>
<body>
<?php 

	$dbconnect = pg_connect("host=localhost port=5432 dbname=spindle user=postgres password=postgres options='--client_encoding=UTF8'")
		or die('Connection impossible : ' . pg_last_error());

	$query = 'SELECT * FROM logs ORDER BY id';
	$result = pg_query($query) or die ('Requête impossible : ' . pg_last_error());

	echo "<table>\n";
	while ($line = pg_fetch_array($result, null, PGSQL_ASSOC)) {
    	echo "\t<tr>\n";
    	foreach ($line as $col_value) {
        	echo "\t\t<td>$col_value</td>\n";
    	}
    	echo "\t</tr>\n";
	}
	echo "</table>\n";

	pg_free_result($result);
	pg_close($dbconnect);


?>
</body>
</html>