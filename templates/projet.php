<p>Nom du projet (acronyme) : <input name="nom" type="text"></p>
<p>Nom complet : <input name="nom_complet" type="text" size="105"></p>
<p>Date de demande : <input type="date" name="date"></p>
<p>Porteur : <input type="text" name="porteur"></p>
<p>Service demandeur : <input type="text" name="service" list="service"></p>
<p>Financement :
	<input type="radio" name="financement" value="oui"> oui
	<input type="radio" name="financement" value="non"> non
</p>
<p>Chef de projet SPIn :
	<input type="radio" name="chefferie" value="oui" onchange="cond_cdp();"> oui
	<input type="radio" name="chefferie" value="non" onchange="cond_cdp();"> non
	<input type="radio" name="chefferie" value="ponctuel" onchange="cond_cdp();"> aide ponctuelle
</p>
<p id="cdp" style="display: none;">Autre chef de projet :
	<input type="radio" name="cdp" value="chu"> CHU
	<input type="radio" name="cdp" value="hors"> hors CHU
</p>
<p>Méthodologie :
	<input type="radio" name="methodologie" value="oui" onchange="cond_methodo();"> oui
	<input type="radio" name="methodologie" value="non" onchange="cond_methodo();"> non
</p>
<p>Analyse :
	<input type="radio" name="analyse" value="oui" onchange="cond_methodo();"> oui
	<input type="radio" name="analyse" value="non" onchange="cond_methodo();"> non
</p>
<p>Valorisation :
	<input type="radio" name="valorisation" value="oui"> oui
	<input type="radio" name="valorisation" value="non"> non
</p>
<p>Avancement :
	<input type="radio" name="avancement" value="reflexion" onchange="cond_cloture();"> <span id="g1">réflexion</span>
	<input type="radio" name="avancement" value="redaction" onchange="cond_cloture();"> <span id="g2">rédaction protocole/candidature</span>
	<input type="radio" name="avancement" value="soumis" onchange="cond_cloture();"> <span id="g3">soumis</span>
	<input type="radio" name="avancement" value="attente" onchange="cond_cloture();"> <span id="g4">en attente</span>
	<input type="radio" name="avancement" value="analyse" onchange="cond_cloture();"> <span id="g5">analyse</span>
	<input type="radio" name="avancement" value="valorisation" onchange="cond_cloture();"> <span id="g6">valorisation</span>
	<input type="radio" name="avancement" value="clos" onchange="cond_cloture();"> <span id="g7">clos</span>
</p>
<p id="cloture" style="display: none;">Date de clôture : <input type="date" name="date_cloture"></p>
<p id="methodo" style="display: none;">Methodologiste/Analyste : <input type="text" name="utilisateur" list="utilisateurs"></p>
<p>
	Résumé : <br>
	<textarea name="resume" cols="80" rows="10"></textarea>
</p>
<div id="candidature"><p>Candidatures</p></div>
<button type="button" onclick="add_candidature();" id="addcandidature">Ajouter une candidature</button>
<div id="valorisation"><p>Valorisations</p></div>
<button type="button" onclick="add_valo();" id="addvalo">Ajouter une valorisation
</button>