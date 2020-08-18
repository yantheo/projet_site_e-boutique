<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<title>Projet e-boutique</title>
	<link rel="stylesheet" href="<?php echo RACINE_SITE; ?>inc/css/style.css">
</head>
<body>
	<header>
		<div class="conteneur">
			<span>
				<a href="" title="Projet e-boutique">MonSite.com</a>
			</span>
			<nav>
				<?php
				//Menu pour l'administrateur du site
				if(membreEstConnecteEtAdmin())
				{
					echo '<a href="' . RACINE_SITE . 'admin/gestion_membre.php">Gestion des membres</a>';
					echo '<a href="' . RACINE_SITE . 'admin/gestion_commande.php">Gestion des commandes</a>';
					echo '<a href="' . RACINE_SITE . 'admin/gestion_boutique.php">Gestion de la boutique</a>';
				}
				//Menu pour le membre du site
				if(membreEstConnecte())
				{
					echo '<a href="' . RACINE_SITE . 'profil.php">Voir votre profil</a>';
					echo '<a href="' . RACINE_SITE . 'boutique.php">Accès à la boutique</a>';
					echo '<a href="' . RACINE_SITE . 'panier.php">Voir votre panier</a>';
					echo '<a href="' . RACINE_SITE . 'connexion.php?action=deconnexion">Se déconnecter</a>';
				}
				//Menu pour le visiteur du site
				else
				{
					echo '<a href="' . RACINE_SITE . 'inscription.php">Inscription</a>';
					echo '<a href="' . RACINE_SITE . 'connexion.php">Connexion</a>';
					echo '<a href="' . RACINE_SITE . 'boutique.php">Accès à la boutique</a>';
					echo '<a href="' . RACINE_SITE . 'panier.php">Voir votre panier</a>';
				}
				?>
			</nav>
		</div>
	</header>
	<section>
		<div class="conteneur">