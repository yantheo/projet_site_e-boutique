<?php require_once("inc/init.inc.php"); 
//--------------------TRAITEMENT PHP------------------------

//Pour gérer la déconnexion:
//Si le membre clic sur le lien déconnection. Il sera déconnecté et sa section sera détruite
if(isset($_GET['action']) && $_GET['action'] == "deconnexion")
{
    session_destroy();
}
//Si l'abonné est déja connecté, il sera renvoyé sur la page profil
if(membreEstConnecte())
{
    header("location:profil.php");
}

//Pour gérér la connexion
if($_POST)
{	
	//Variable pour voir si on récupère bien les POST du formulaire
	//$contenu .= "Pseudo: '$_POST[pseudo]' <br>Mot de passe: '$_POST[mdp]'.  ";
	
	//Requête pour vérifier si le pseudo tapé correspond à celui dans la BDD
	$resultat = executeRequete("SELECT * FROM membre WHERE pseudo='$_POST[pseudo]'");
	
	//Si la requête renvoie un résultat
	if($resultat->num_rows !=0)
	{
		$contenu .= "<div class='validation'>Pseudo connu</div>";
		//on récupère les données de la requête avec la méthode fetch_assoc()
		$membre = $resultat->fetch_assoc();
		//On vérifie si le mot de passe inscrit est bien celui inscrit dans la base de donnée
		if($membre['mdp'] == $_POST['mdp'])
		{
			$contenu .= "<div class='validation'>Pseudo connu</div>";
			
			//Boucle foreach pour conserver les informations du membre (ici $element) pour les garder en memoire dans la SESSION
			//Par mesure de sécurité, on ne conserve pas le mot de passe en précisant if($indice != 'mdp')
			foreach($membre as $indice => $element)
			{
				if($indice != 'mdp')
				{
					$_SESSION['membre'][$indice] = $element;
				}
			}
			//Si le pseudo et mot de passe est correct. On amène le membre sur la page profil 
			header("location:profil.php");
		}
		//Si le mot de passe ne correspond pas, on envoie un message d'erreur
		else
			
		{
			$contenu .= "<div class='erreur'>Erreur sur le mot de passe</div>";
		}
	}
	//Si le pseudo ne correspond pas on envoie un message d'erreur.
	else
	{
		$contenu .= "<div class='erreur'>Erreur de pseudo</div>";
	}
	
}
?>
<?php require_once("inc/haut.inc.php"); ?>
<?php echo $contenu; ?>

<form method="post" action="">
	<label for="pseudo">Pseudo</lable><br>
	<input type="text" id="pseudo" name="pseudo"><br><br>
	
	<label for="mdp">Mot de passe</lable><br>
	<input type="password" id="mdp" name="mdp"><br><br>
	
	<input type="submit" value="Se connecter">
</form>

<?php require_once("inc/bas.inc.php"); ?>