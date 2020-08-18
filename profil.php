<?php 
require_once("inc/init.inc.php");
//---------------------TRAITEMENT PHP-----------------
if(!membreEstConnecte()) header("location:connexion.php");
//debug($_SESSION);

$contenu .= "<h2 style='text-align: center'>Bonjour <strong>" . $_SESSION["membre"]["pseudo"] . "!</strong></h2><br><br>";
$contenu .= "<div style='border:solid; width:25%;margin:0 auto;'><div style='background:yellow;padding:5px'><strong> Voici vos informations de profil</strong></div>";
$contenu .= "<p>votre mail est: " . $_SESSION["membre"]["email"] . "<br>";
$contenu .= "votre ville est: " . $_SESSION["membre"]["ville"] . "<br>";
$contenu .= "votre code postal est: " . $_SESSION["membre"]["code_postal"] . "<br>";
$contenu .= "votre adresse est: " . $_SESSION["membre"]["adresse"] . "</p></div><br><br>";

require_once("inc/haut.inc.php");
echo $contenu;
require_once("inc/bas.inc.php");
?>