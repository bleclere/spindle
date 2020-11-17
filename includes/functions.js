/* Fonctions javascripts du projet SPINDLE */

// faire apparaître un champ conditionnellement pour la saisie du méthodologiste
function cond_methodo() {

	var condition = document.getElementsByName("methodologie")[0].checked || document.getElementsByName("analyse")[0].checked;

	if (condition) {
		document.getElementById("methodo").style.display = "inline";
	} else {
		document.getElementById("methodo").style.display = "none";
	}
}


// faire apparaître conditionnellement un champ pour la date de clôture
function cond_cloture() {
	var condition = document.getElementsByName("avancement")[6].checked;

	if (condition) {
		document.getElementById("cloture").style.display = "inline";
	} else {
		document.getElementById("cloture").style.display = "none";
	}
}

// faire apparaître conditionnellement un champ pour le CdP
function cond_cdp() {
	var condition = document.getElementsByName("chefferie")[1].checked;

	if (condition) {
		document.getElementById("cdp").style.display = "inline";
	} else {
		document.getElementById("cdp").style.display = "none";
	}

}

// faire apparaître les champs liés à la candidature
function add_candidature() {

	var element = document.getElementById("candidature");

	//var index = element.getElementsByTagName("div").length + 1;
	var line = document.createElement("div");


	var cross = document.createElement("span");
	cross.appendChild(document.createTextNode("X"));
	cross.className = "cross";
	cross.onclick = function() {
		this.parentNode.remove();
	};
	line.appendChild(cross);


	var data_block = document.createElement("div");
	data_block.style.display = "inline-block";
	data_block.className = "candid_data";

	
	var aap = document.createElement("p");
	aap.appendChild(document.createTextNode("AAP/AO : "));
	var aap_input = document.createElement("input");
	aap_input.type = "text";
	var list = document.getElementById('aap').id;
		aap_input.setAttribute('list', list);
	aap_input.name = "aap";
	aap.appendChild(aap_input);


	var annee = document.createElement("p");
	annee.appendChild(document.createTextNode("Année : "));
	var annee_input = document.createElement("input");
	annee_input.type = "number";
	annee_input.name = "annee";
	annee_input.min = "2020";
	annee_input.max = "2050";
	annee.appendChild(annee_input);

	var budget = document.createElement("p");
	budget.appendChild(document.createTextNode("Budget : "));
	var budget_input = document.createElement("input");
	budget_input.type = "number";
	budget_input.name = "budget";
	budget.appendChild(budget_input);
	budget.appendChild(document.createTextNode(" €"));

	var statut = document.createElement("p");
	statut.appendChild(document.createTextNode("Obtenu : "));
	var list_statut = ["oui", "non"];
	list_statut.forEach(function(x) {
		var statut_input = document.createElement("input");
		//statut_input.name = "statut";
		statut_input.type = "radio";
		statut_input.value = x;
		statut_input.className = "statut";
		statut.appendChild(statut_input);
		statut.appendChild(document.createTextNode(" " + x + " "));
	});

	data_block.appendChild(aap);
	data_block.appendChild(annee);
	data_block.appendChild(budget);
	data_block.appendChild(statut);

	line.appendChild(data_block);

	element.appendChild(line);
}

// fonction pour ajouter un champ d’entrée de valorisation pour les projets.
function add_valo() {


	var element = document.getElementById("valorisation");

	var line = document.createElement("div");


	var cross = document.createElement("span");
	cross.appendChild(document.createTextNode("X"));
	cross.className = "cross";
	cross.onclick = function() {
		this.parentNode.remove();
	};
	line.appendChild(cross);

	var data_block = document.createElement("div");
	data_block.style.display = "inline-block";
	data_block.className = "valo_data";

	var ref = document.createElement("p");
	ref.appendChild(document.createTextNode("Référence : "));
	var ref_input = document.createElement("input");
	ref_input.type = "text";
	ref_input.name = "reference";
	ref_input.size = 105;

	ref.appendChild(ref_input);


	var type = document.createElement("p");
	type.appendChild(document.createTextNode("Type de valorisation :"));
	var list_type = ["article", "poster", "communication orale"];
	list_type.forEach(function(x) {
		var type_input = document.createElement("input");
		//type_input.name = "type";
		type_input.className = "type";
		type_input.type = "radio";
		type_input.value = x;
		type.appendChild(type_input);
		type.appendChild(document.createTextNode(" " + x + " "));
	});

	data_block.appendChild(type);
	data_block.appendChild(ref);

	line.appendChild(data_block);

	element.appendChild(line);
}
