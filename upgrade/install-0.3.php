<?php
function upgrade_module_0_3($module) {
	// On exécute la requête SQL d’installation
	$sql_file = dirname(__FILE__) . "/sql/install-0.3.sql";

	// On test la valeur de retour de l'appel de la fonction loadSQLFile
	if(!$module->loadSQLFile($sql_file)) {
		// Si la méthode install d’un module retourne false PrestaShop affiche automatiquement un message d’erreur pour indiquer au marchand qu’un problème est survenu
		return false;
	}

	// Installation réussie
	return true;
}