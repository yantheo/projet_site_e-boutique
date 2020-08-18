<?php
require_once("../inc/init.inc.php");

//---------------------------TRAITEMENT PHP-----------------------------
//-------------------------VERIFICATION ADMIN---------------------------
if(!membreEstConnecteEtAdmin())
{
	header("location:../connexion.php");
	exit();
}
//-------------------------SUPRESSION PRODUIT---------------------------
//On détect le clic sur l'action "supression"
if(isset($_GET['action']) && $_GET['action'] == "suppression")
{   $contenu .= $_GET['id_produit']
	
	//On sort tous les informations de la id_produits dans la basse
    $resultat = executeRequete("SELECT * FROM produit WHERE id_produit=$_GET[id_produit]");
    $produit_a_supprimer = $resultat->fetch_assoc();
	
	//On suprime la photo (avec le chemin de la photo) sur le serveur lors de la supression
    $chemin_photo_a_supprimer = $_SERVER['DOCUMENT_ROOT'] . $produit_a_supprimer['photo'];
    if(!empty($produit_a_supprimer['photo']) && file_exists($chemin_photo_a_supprimer)) unlink($chemin_photo_a_supprimer);
    
	//Requête de supression du produit
	executeRequete("DELETE FROM produit WHERE id_produit=$_GET[id_produit]");
	
	//message de confirmation de l'action "supression"
    $contenu .= '<div class="validation">Suppression du produit : ' . $_GET['id_produit'] . '</div>';
	
	//dès que le produit est supprimer nous retournons sur l'affichage des produits
    $_GET['action'] = 'affichage';
}

//-------------------------ENREGISTREMENT PRODUIT-----------------------
if(!empty($_POST))
{	
	//variable $photo_bdd à vide pour éviter erreur undefined si aucune photo n'est ajoutée
	$photo_bdd = "";
	//debug($_POST);
	//Si une photo a été uplaodée
	if(!empty($_FILES["photo"]["name"]))
	{
		debug($_FILES);
		//nous changeons le nom de la photo en y ajoutant la référence
		$nom_photo = $_POST["reference"] . '_' . $_FILES['photo']['name'];
		$photo_bdd = RACINE_SITE . "photo/$nom_photo";
		$photo_dossier = $_SERVER['DOCUMENT_ROOT'] . RACINE_SITE . "/photo/$nom_photo";
		copy($_FILES["photo"]["tmp_name"],$photo_dossier);
	}
	foreach($_POST AS $indice => $valeur)
	{
		$_POST[$indice] = htmlentities(addSlashes($valeur));
	}
	//Requête d'insertion des produits dans la BDD
	executeRequete("INSERT INTO produit (id_produit, reference, categorie, titre, description, couleur, taille, public, photo, prix, stock) 
	VALUES ('', '$_POST[reference]', '$_POST[categorie]', '$_POST[titre]', '$_POST[description]', '$_POST[couleur]', '$_POST[taille]', 
	'$_POST[public]',  '$photo_bdd',  '$_POST[prix]',  '$_POST[stock]')");
	$contenu .= "<div class='validation'>Le produit a été ajouté</div>";	
}
//-------------------------------LIENS PRODUITS--------------------------
$contenu .= '<a href="?action=affichage">Affichage des produits</a><br>';
$contenu .= '<a href="?action=ajout">Ajout d\'un produit</a><br><br><hr><br>';
//--- AFFICHAGE PRODUITS ---//
if(isset($_GET['action']) && $_GET['action'] == "affichage")
{
    $resultat = executeRequete("SELECT * FROM produit");
     
    $contenu .= '<h2> Affichage des Produits </h2>';
    $contenu .= 'Nombre de produit(s) dans la boutique : ' . $resultat->num_rows;
    $contenu .= '<table border="1"><tr>';
     
    while($colonne = $resultat->fetch_field())
    {    
        $contenu .= '<th>' . $colonne->name . '</th>';
    }
    $contenu .= '<th>Modification</th>';
    $contenu .= '<th>Supression</th>';
    $contenu .= '</tr>';
 
    while ($ligne = $resultat->fetch_assoc())
    {
        $contenu .= '<tr>';
        foreach ($ligne as $indice => $information)
        {
            if($indice == "photo")
            {
                $contenu .= '<td><img src="' . $information . '" ="70" height="70"></td>';
            }
            else
            {
                $contenu .= '<td>' . $information . '</td>';
            }
        }
        $contenu .= '<td><a href="?action=modification&id_produit=' . $ligne['id_produit'] .'"><img style="height:70px;padding:0;" src="../inc/img/edit.png"></a></td>';
        $contenu .= '<td><a href="?action=suppression&id_produit=' . $ligne['id_produit'] .'" OnClick="return(confirm(\'En êtes vous certain ?\'));"><img style="width:50px;height:50px;" src="../inc/img/delete.png"></a></td>';
        $contenu .= '</tr>';
    }
    $contenu .= '</table><br><hr><br>';
}

//-------------------------------AFFICHAGE HTML--------------------------
require_once("../inc/haut.inc.php");
echo $contenu;
?>

<h1>Formulaire Produits</h1>
<form method="post" enctype="multipart/form-data" action="">

	<label for="reference">Référence</label><br>
	<input type="text" id="reference" name="reference" placeholder="la référence du produit">
	<br><br>
	
	<label for="categorie">Categorie</label><br>
	<input type="text" id="categorie" name="categorie" placeholder="la categorie du produit">
	<br><br>
	
	<label for="titre">Titre</label><br>
	<input type="text" id="titre" name="titre" placeholder="le titre du produit">
	<br><br>
	
	<label for="description">Description</label><br>
	<textarea id="description" name="description" placeholder="la description du produit"></textarea>
	<br><br>
	
	<label for="couleur">Couleur</label><br>
	<input type="text" id="couleur" name="couleur" placeholder="la couleur du produit">
	<br><br>
	
	<label for="taille">Taille</label><br>
	<select name="taille">
		<option value="S">S</option>
		<option value="M">M</option>
		<option value="L">L</option>
		<option value="XL">XL</option>
	</select>
	<br><br>
	
	<label for="public">Public</label><br>
	<input type="radio" name="public" value="m" checked="">Homme
	<input type="radio" name="public" value="f">Femme
	<br><br>
	
	<label for="photo">Photo</label><br>
	<input type="file" id="photo" name="photo">
	<br><br>
	
	<label for="prix">Prix</label><br>
	<input type="text" id="prix" name="prix" placeholder="le prix du produit">
	<br><br>
	
	<label for="stock">Stock</label><br>
	<input type="text" id="stock" name="stock" placeholder="le stock du produit">
	<br><br>
	
	<input type="submit" value="enregistrement du produit">
</form>
<?php require_once("../inc/bas.inc.php"); ?>

	


























