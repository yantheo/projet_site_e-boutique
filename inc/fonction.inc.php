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
//------------------------------FONCTION PANIER-----------------------------------
function creationDuPanier()
{
   if(!isset($_SESSION['panier']))
   {
      $_SESSION['panier'] = array();
      $_SESSION['panier']['titre'] = array();
      $_SESSION['panier']['id_produit'] = array();
      $_SESSION['panier']['quantite'] = array();
      $_SESSION['panier']['prix'] = array();
   }
}
//------------------------------------
function ajouterProduitDansPanier($titre, $id_produit, $quantite, $prix)
{
    creationDuPanier(); 
    $position_produit = array_search($id_produit,  $_SESSION['panier']['id_produit']);
    if($position_produit !== false)
    {
         $_SESSION['panier']['quantite'][$position_produit] += $quantite ;
    }
    else
    {
        $_SESSION['panier']['titre'][] = $titre;
        $_SESSION['panier']['id_produit'][] = $id_produit;
        $_SESSION['panier']['quantite'][] = $quantite;
        $_SESSION['panier']['prix'][] = $prix;
    }
}
//------------------------------------
function montantTotal()
{
   $total=0;
   for($i = 0; $i < count($_SESSION['panier']['id_produit']); $i++)
   {
      $total += $_SESSION['panier']['quantite'][$i] * $_SESSION['panier']['prix'][$i];
   }
   return round($total,2); 
}
//------------------------------------
function retirerProduitDuPanier($id_produit_a_supprimer)
{
    $position_produit = array_search($id_produit_a_supprimer,  $_SESSION['panier']['id_produit']);
    if ($position_produit !== false)
    {
        array_splice($_SESSION['panier']['titre'], $position_produit, 1);
        array_splice($_SESSION['panier']['id_produit'], $position_produit, 1);
        array_splice($_SESSION['panier']['quantite'], $position_produit, 1);
        array_splice($_SESSION['panier']['prix'], $position_produit, 1);
    }
}
?>