<?php
//Creation d'une fonction pour executer nos requêtes avec en argument notre requête SQL
function executeRequete($req)
{	
	//Déclaration d'une variable global qui permet d'accéder à la variable $mysqli présent dans init.inc.php
	global $mysqli;
	$resultat = $mysqli->query($req);
	//Gestion msg en cas d'erreur sur une de nos requêtes
	if(!$resultat)
	{
		die("Erreur sur la requete SQL.<br>Message : " . $mysqli->error . "<br>Code: " . $req);
	}
	return $resultat;
}

//Fonction destinée à recevoir 1 ou 2 arguments. 
function debug($var, $mode=1)
{
	echo "<div style='background: orange; padding: 5xp; float: right; clear: both; '>";
	//fonction prédéfinie qui retourne un tablea array contenant des informations tel que la ligne 
	//et le fichier ou est exécuté la fonction
	$trace = debug_backtrace();
	
	//Extrait la première valeur d'un tableau et la retourne. Dnas notre cas cela permet de 
	//retirer une dimension au tableau array $trace
	$trace = array_shift($trace);
	
	//Permet de savoir quel fichier doit être debugger
	echo "Debug demandé dans le fichier : $trace[file] à la ligne $trace[line].";
	if($mode === 1)
	{
		echo "<pre>"; print_r($var); echo "</pre>";
	}
	else
	{
		echo "<pre>"; var_dump($var); echo "</pre>";
	}
	echo "</div>";
}
//---------------------------TRAITEMENT SESSION MEMBRE & ADMIN-------------------
function membreEstConnecte()
{	
	//Si la SESSION membre n'est pas défini, l'internaute n'est pas connecté (false)
	if(!isset($_SESSION['membre'])) return false;
	//Sinon il est connecté (true)
	else return true;
}

function membreEstConnecteEtAdmin()
{	
	//Si le membre est connecté et que son status = 1 (dans la base de donnée)
	// renvoie true et le membre est admin
	if(membreEstConnecte() && $_SESSION['membre']['statut'] == 1) return true;
	else return false;
}
?>