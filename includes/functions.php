<?php 

	// Fonctions nécessaires au projet :
	// ---------------------------------


	// fonction de render d’une page :
	function render($page) {
		$adresse = "templates/" . $page;
		require("templates/header.php");
		require($adresse);
		require("templates/footer.php");
	}

	// fonction d’ouverture de connection avec la base de données :
	function query($text) {
		$dbconnect = pg_connect("dbname=spindle port=5432 user=postgres password=postgres") or die("Connection à la BdD impossible : " . pg_last_error());

		$result = pg_query($text) or die("Requête impossible : " . pg_last_error());

		$ret = pg_fetch_all($result);

		pg_free_result($result);
		pg_close($dbconnect);

		return $ret;
	}


	// fonction pour créer la datalist utilisateur, utilisée pour préremplir les champs utilisateurs :
	function create_datalist() {

		$result = query("SELECT nom, prenom FROM utilisateurs WHERE statut = 'methodo' ORDER BY nom");
		var_dump($result);

		/*echo "<datalist id=\"utilisateurs\">";

		while($row = pg_fetch_row($result)) {
			echo "<option value=\"" . $row[0] . ", " . $row[1] . "\">";
		}

		echo "</datalist>";*/
	}




?>