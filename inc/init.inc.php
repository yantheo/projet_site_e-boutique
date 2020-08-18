<?php
//Connexion à la BDD
$mysqli = new mysqli("localhost","root","","site");

//GESTION MSG ERREUR EN CAS DE PROBLEME DE CONNECTION AV LA BDD
if($mysqli->connect_error) die('Un problème lors de la tentative de connexion à la BDD: '
								. $mysqli ->connect_error);
								
//ENCODAGE DE LA BASE DE DONNEES
$mysqli->set_charset("utf8");

//-----SESSION
session_start();

//-----CHEMIN RACINE DU SITE
define("RACINE_SITE","/php/site/");

//-----VARIABLE VIDE POUR MESSAGE A ADRESSE AUX UTILISATEURS
$contenu = "";

//-----AUTRES INCLUSIONS
require_once("fonction.inc.php");
?>