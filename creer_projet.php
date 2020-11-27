<!DOCTYPE html>
<html>
<head>
	<title>Créer un projet</title>
	<meta charset="utf8">
	<link rel="stylesheet" type="text/css" href="includes/css/style.css">
	<script src="includes/functions.js"></script>
</head>
<body>

	<h1>Créer un projet</h1>
	
		
	<?php include("templates/projet.php"); ?>
	<div id="candidature"><p>Candidatures</p></div>
	<button type="button" onclick="add_candidature();" id="addcandidature">Ajouter une candidature</button>
	<div id="valorisation"><p>Valorisations</p></div>
	<button type="button" onclick="add_valo();" id="addvalo">Ajouter une valorisation
	</button>

	<p><button type="button" onclick="submit();">Soumettre</button></p>


	<?php include("includes/datalists-projets.php"); ?>


	<?php create_datalist(); ?>


	<script>


		// vérifier qu’au moins un nom d’étude est fourni
		function submit() {
			if (document.getElementsByName("nom")[0].value.length == 0) {
				alert("Saisir au moins un nom de projet");
			} else {
				
				submit_project(submit_candid);

			}
		}

		function submit_project(func) {
			// collecter les données
			var avancement;

			for (var i = 0; i < document.getElementsByName("avancement").length; i++) {
				if (document.getElementsByName("avancement")[i].checked) {
					avancement = document.getElementsByName("avancement")[i].value;
					break;
				} else {
					avancement = "";
				}
			}

			//alert(avancement);

			var post = {
				nom: document.getElementsByName("nom")[0].value,
				nom_complet: document.getElementsByName("nom_complet")[0].value,
				date: document.getElementsByName("date")[0].value,
				porteur: document.getElementsByName("porteur")[0].value,
				service: document.getElementsByName("service")[0].value,
				financement: document.getElementsByName("financement")[0].checked ? "oui" : document.getElementsByName("financement")[1].checked ? "non" : "",
				chefferie: document.getElementsByName("chefferie")[0].checked ? "oui" : document.getElementsByName("chefferie")[1].checked ? "non" : document.getElementsByName("chefferie")[2].checked ? "ponctuel" : "",
				cdp: document.getElementsByName("cdp")[0].checked ? "chu" : document.getElementsByName("cdp")[1].checked ? "hors" : "",
				methodologie: document.getElementsByName("methodologie")[0].checked ? "oui" : document.getElementsByName("methodologie")[1].checked ? "non" : "",
				analyse: document.getElementsByName("analyse")[0].checked ? "oui" : document.getElementsByName("analyse")[1].checked ? "non" : "",
				valorisation: document.getElementsByName("valorisation")[0].checked ? "oui" : document.getElementsByName("valorisation")[1].checked ? "non" : "",
				avancement: avancement,
				date_cloture: document.getElementsByName("date_cloture")[0].value,
				utilisateur: document.getElementsByName("utilisateur")[0].value,
				resume: document.getElementsByName("resume")[0].value,
			};



			const requete = new XMLHttpRequest(),
				  data = new FormData();

			for (datum in post) {
				data.append(datum, post[datum]);
			}

			requete.onreadystatechange = function () {
				if (requete.readyState === XMLHttpRequest.DONE) {
					if (requete.status === 200) {
						func(requete.responseText, submit_valo);
					} else {
						alert("There has been a problem with the query.");
					}
				}
			};

			requete.open('POST', 'submit-project.php');
			requete.send(data);
			

		}

		function submit_candid(id, callback)  {

			// saisie des données de candidatures
			// ----------------------------------

			const candid = document.getElementsByClassName("candid_data");
			var done = false;

			if (candid.length > 0) {
				for (let line =0; line < candid.length; line++) {

					const requete_candid = new XMLHttpRequest(),
					      data_candid = new FormData();

					let statut;
					//let line_data = candid[line];


					for (let i = 0; i < 2 ; i++) {
						if (document.getElementsByClassName("statut")[(line * 2) + i].checked) {
							statut = document.getElementsByClassName("statut")[(line * 2) + i].value;
							break;
						} 
						statut = "";
					}

					let post_candid = {
						aap: document.getElementsByName("aap")[line].value,
						annee: document.getElementsByName("annee")[line].value,
						budget: document.getElementsByName("budget")[line].value,
						statut: statut,
						projet_id: id
					};

					console.log(post_candid);

					for (let datum in post_candid) {
						data_candid.append(datum, post_candid[datum]);
					}

					/*requete_candid.addEventListener("load", function(event) {
						alert('Données candidatures saisies.');
					});

					requete_candid.addEventListener("error", function(event) {
						alert("Erreur dans la saisie des données de candidature");
					});*/

					requete_candid.open("POST", "submit-candid.php");
					requete_candid.send(data_candid);

				}
			}

			if(typeof(callback) !== "undefined") {
				callback(id);
			}
			
		}


		function submit_valo(id) {

			// ajout des données de valorisation
			//----------------------------------

			const valo = document.getElementsByClassName("valo_data");

			if (valo.length > 0) {
				for (let line = 0; line < valo.length; line++) {

					const requete_valo = new XMLHttpRequest(),
						  data_valo = new FormData();

					let type;
					let type_list = document.getElementsByClassName("type");
					let num_items = type_list.length / valo.length;

					for (let i = 0; i < num_items; i++) {

						if (type_list[line * num_items + i].checked) {
							type = type_list[line * num_items + i].value;
							break;
						}

						type = "";

					}


					let post_valo = {
						type: type,
						ref: document.getElementsByName("reference")[line].value,
						projet_id: id
					};


					for (let datum in post_valo) {
						data_valo.append(datum, post_valo[datum]);
					}

					/*requete_valo.addEventListener("load", function(event) {
						alert("Données de valorisation saisies.");
					});

					requete_valo.addEventListener("error", function(event) {
						alert("Erreur dans la saisie des données de candidature");
					});*/

					requete_valo.open("POST", "submit-valo.php");
					requete_valo.send(data_valo);

				}
			}
		}
		
	</script>

</body>
</html>
