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


?>