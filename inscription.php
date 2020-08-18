<?php require_once("inc/init.inc.php"); ?>
<?php require_once("inc/haut.inc.php"); ?>
<?php
//-----------------TRAITEMENT PHP----------------

if($_POST)
{	//on utilise notre fonction debug pour tester les POST effectués
	debug($_POST);
	
	//On vérifie qu'il n'y a pas de mauvais caractère dans le pseudo. preg_match (expression régulière) est relié au pattern dans le formulaire
	//Renvoie 1 pour true - 0 pour false
	$verif_caratere = preg_match("#^[a-zA-Z0-9._-]+$#", $_POST['pseudo']);
	
	//Si $verif_caractere ne renvoie pas true et que le pseudo est inférieur à 1 ou supérieur à 20
	//on envoie un message d'erreur
	if(!$verif_caratere && (strlen($_POST['pseudo']) < 1 || strlen($_POST['pseudo']) > 20))
	{
		$contenu .= "<div class='erreur'>Votre pseudo doit contenir entre 1 et 20 caractères. <br>
					Caractère accepté : Lettre de A à Z et chiffre de 0 à 9.</div>";
	}
	//Si pas d'erreur, on va vérifier la disponibilité du pseudo
	else
	{	//requête pour vérifié si le pseudo existe déja dans la base
		$membre = executeRequete("SELECT * FROM membre WHERE pseudo='$_POST[pseudo]'");
		//Si la variable $membre renvoie 1 = pseudo déja présent donc indisponible
		if($membre->num_rows>0)
		{
			$contenu .= "<div class='erreur'>Pseudo indisponible! Veuillez en choisir un autre svp.</div>";
		}
		else
		//L'inscription peut être validée
		{	
			//Ligne permettant de crypter le mot de passe de l'abonné
			//$_POST['mdp'] = md5($_POST['mdp']);
			
			//Boucle sur toutes les saisies qui permet de passer les fonctions prédéfinies htmlentities et addslahes
			//Permet de se protéger contre de potentiels attaques SQL
			foreach($_POST as $indice => $valeur)
			{
				$_POST[$indice] = htmlentities(addslashes($valeur));
			}
			//Requête d'insertion du membre dans la base de donnée
			executeRequete("INSERT INTO membre (pseudo, mdp, nom, prenom, email, civilite, ville, code_postal, adresse)
							VALUES('$_POST[pseudo]', '$_POST[mdp]', '$_POST[nom]', '$_POST[prenom]', '$_POST[email]', '$_POST[civilite]', 
							'$_POST[ville]', '$_POST[code_postal]', '$_POST[adresse]')");
			//Message de validation d'inscription
			$contenu .= "<div class='validation'>Vous êtes bien inscrit à notre site web. <a href=\"connexion.php\">
						<u>Cliquez ici pour vous connecter</u></a></div>";
		}
	}
}
//----------------------AFFICHAGE----------------------------
?>
<?php echo $contenu; ?>

<form method="post" action="">
	<label for="pseudo">Pseudo</label><br>
	<input type="text" id="pseudo" name="pseudo" maxlength="20" placeholder="Votre pseudo" 
			pattern="[a-zA-Z0-9-_.]{1,20}" title="caractères acceptés : a-zA-Z0-9-_." required="required"><br><br>
			
	<label for="mdp">Mot de passe</label><br>
	<input type="password" id="mdp" name="mdp" required="required"><br><br>
	
	<label for="nom">Nom</label><br>
	<input type="text" id="nom" name="nom" placeholder="Votre nom"><br><br>
	
	<label for="prenom">Prénom</label><br>
	<input type="text" id="prenom" name="prenom" placeholder="Votre prénom"><br><br>
	
	<label for="email">Email</label><br>
	<input type="email" id="email" name="email" placeholder="exemple@mail.com"><br><br>
	
	<label for="civilite">Civilité</label>
	<input name="civilite" value="m" checked="" type="radio">Homme
	<input name="civilite" value="f" type="radio">Femme<br><br>
	
	<label for="ville">Ville</label><br>
	<input type="text" id="ville" name="ville" placeholder="Votre ville" 
			pattern="[a-zA-Z0-9-_.]{5,20}" title="caractères acceptés : a-zA-Z0-9-_."><br><br>
	
	<label for="code_postal">Code Postal</label><br>
	<input type="text" id="code_postal" name="code_postal" placeholder="Votre code postal" 
			pattern="[0-9]{5}" title="5 chiffres requis: 0-9"><br><br>
	
	<label for="adresse">Adresse</label><br>
	<textarea id="adresse" name="adresse" placeholder="Votre adresse" 
			pattern="[a-zA-Z0-9-_.]{5,15}" title="caractères acceptés : a-zA-Z0-9-_."></textarea><br><br>
	
	<input type="submit" name="inscription" value="S'inscrire">
</form>
<?php require_once("inc/bas.inc.php"); ?>