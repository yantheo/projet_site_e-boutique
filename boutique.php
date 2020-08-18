<?php
require_once("inc/init.inc.php");
require_once("inc/haut.inc.php");
//--------------------------------- TRAITEMENTS PHP ---------------------------------//
//--- AFFICHAGE DES CATEGORIES ---//
$categories_des_produits = executeRequete("SELECT DISTINCT categorie FROM produit");
$contenu .= '<div style="float: left; : 30%; background: #f2f2f2; min-height: 500px; margin-right: 10%; padding-top: 10px; text-align: center; ">';
$contenu .= "<ul style='list-style: none; padding: 0;'>";
while($cat = $categories_des_produits->fetch_assoc())
{
    $contenu .= "<li><a style='display: block; padding: 10px; color: blue;' href='?categorie=" . $cat['categorie'] . "'>" . $cat['categorie'] . "</a></li>";
}
$contenu .= "</ul>";
$contenu .= "</div>";
//--- AFFICHAGE DES PRODUITS ---//
$contenu .= '<div style="float: left; : 60%; ">';
if(isset($_GET['categorie']))
{
    $donnees = executeRequete("select id_produit,reference,titre,photo,prix from produit where categorie='$_GET[categorie]'");  
    while($produit = $donnees->fetch_assoc())
    {
        $contenu .= '<div style="float: left; : 30%; text-align: center; padding: 5%; border-bottom: 1px solid #c0c0c0;">';
        $contenu .= "<h2>$produit[titre]</h2>";
        $contenu .= "<a href=\"fiche_produit.php?id_produit=$produit[id_produit]\"><img src=\"$produit[photo]\" =\"130\" height=\"100\"></a>";
        $contenu .= "<p>$produit[prix] €</p>";
        $contenu .= '<a href="fiche_produit.php?id_produit=' . $produit['id_produit'] . '">Voir la fiche</a>';
        $contenu .= '</div>';
    }
}
$contenu .= '</div>';
//--------------------------------- AFFICHAGE HTML ---------------------------------//
echo $contenu;
require_once("inc/bas.inc.php"); ?>