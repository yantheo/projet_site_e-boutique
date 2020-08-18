<?php
require_once("inc/init.inc.php");
//---------------------TRAITEMENT PHP------------------------
//Si l'id du produit est récupéré, nous le recupérons avec notre requête
if(isset($_GET['id_produit']))
{
$resultat = executeRequete("SELECT * FROM produit WHERE id_produit='$_GET[id_produit]'");}
//Si la base de donné ne renvoie aucun resultat, cela veut dire que le produit n'existe pas (ou plus)
//Redirection sur la boutique
if($resultat->num_rows <= 0)
{
	header("location:boutique.php"); exit();
}
//Si l'id du produit existe dans la base, on récupere les infos pour créer la fiche produit
$produit = $resultat->fetch_assoc();
$contenu .= "<h2>Titre : $produit[titre]</h2><hr><br>";
$contenu .= "<p>Categorie: $produit[categorie]</p>";
$contenu .= "<p>Couleur: $produit[couleur]</p>";
$contenu .= "<p>Taille: $produit[taille]</p>";
$contenu .= "<img src='$produit[photo]' ='150' height='150'>";
$contenu .= "<p><i>Description: $produit[description]</i></p><br>";
$contenu .= "<p>Prix : $produit[prix] €</p><br>";

//Si le produit est disponible = stock > 0
if($produit['stock'] > 0)
{
	//On affiche le nombre de produit disponible
	$contenu .= "<i>Nombre de produit(s) disponible(s): $produit[stock]</i><br><br>";
	//creation d'un formulaire, le membre sera dirigé sur la panier.php s'il clique sur le bouton.
	$contenu .= "<form method='post' action='panier.php'>";
	$contenu .= "<input type='hidden' name='id_produit' value='$produit[id_produit]'>";
	$contenu .= "<label for='quantite'>Quantité : </label>";
	$contenu .= "<select id='quantite' name='quantite'>";
	//On peut sélectionner jusqu'à 5 produits maximum et pas plus que le stock restant
	for($i = 1; $i <= $produit['stock'] && $i <= 5; $i++)
	{
		$contenu .= "<option>$i</option>";
	}
	$contenu .= "</select>";
	$contenu .= "<input type='submit' name='ajout_panier' value='ajout au panier'>";
	$contenu .= "</form>";
}
//si plus de stock disponible. Message d'erreur.
else
{
	$contenu .= "Rupture de stock!";
}
$contenu .= "<br><a href='boutique.php?categorie=$produit[categorie]'>Retour vers la sélection de $produit[categorie]</a>";
require_once("inc/haut.inc.php");
echo $contenu;
require_once("inc/bas.inc.php");
?>