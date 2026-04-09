<!DOCTYPE html>
<?php include("config.php"); ?>
<?php include("login.php"); ?>
<?php $paramelem="admin"; ?>
<html>
 <?php include("head.php"); ?>
 <!--[if IE6]><body class="ie6 old_ie"><![endif]-->
<!--[if IE7]><body class="ie7 old_ie"><![endif]-->
<!--[if IE8]><body class="ie8"><![endif]-->
<!--[if IE9]><body class="ie9"><![endif]-->
<!--[if !IE]><!--><body><!--<![endif]-->
       <form action="admin.php" method="post">
			<h1>Administration</h1>
		<nav class="navbar navbar-inverse">
			<ul id="menu" class="nav navbar-nav">
				<li><a href="admin.php?type=contenu">Contenus</a></li>
				<?php if ($_SESSION['admingroupe']=="*"){?>
				<li><a href="admin.php?type=page">Pages</a></li>
				<li><a href="admin.php?type=menu">Menus</a></li>
				<?php } ?>
				<li><a href="admin.php?type=evenement">Evénements</a></li>
				<li><a href="admin.php?type=reservation">Reservations</a></li>
				<?php if ($_SESSION['admingroupe']=="*"){?>
				<li><a href="admin.php?type=langue">Langues</a></li>
				<li><a href="admin.php?type=utilisateur">Utilisateurs</a></li>
				<?php } ?>
			</ul>
		</nav>
<?php include("loginsaisie.php"); ?>
<?php
	if (isset($_SESSION['login'])){
		//Page uniquement pour les admins
		if ($paramtype=='page' AND $_SESSION['admingroupe']=="*"){
?>
		<button type="button" onclick="document.location.href='adminpage.php';">Nouvelle page</button>
<?php	
		$reponsepage = $bdd->prepare('SELECT * FROM page');
		$reponsepage->execute();
?>
		<table>
		<tr>
			<th>Page</th>
			<th>Libellé</th>
			<th>Evénement</th>
			<th>Réservation</th>
			<th>Evénement récent</th>
			<th>Présentation</th>
			<th>&nbsp;</th>
		</tr>
<?php			
		while ($donneespage = $reponsepage->fetch()){
?>
		<tr>
			<td><?php echo htmlspecialchars($donneespage['page']); ?></td>
			<td><?php echo htmlspecialchars($donneespage['libelle']); ?></td>
			<td><?php echo htmlspecialchars($donneespage['evenement']); ?></td>
			<td><?php echo htmlspecialchars($donneespage['reservation']); ?></td>
			<td><?php echo htmlspecialchars($donneespage['evtrecent']); ?></td>
			<td><?php echo htmlspecialchars($donneespage['presentation']); ?></td>
			<td><a href="adminpage.php?id=<?php echo $donneespage['id']; ?>">Gerer la page</a></td>
			</tr>
<?php
		}
		$reponsepage->closeCursor(); // Termine le traitement de la requête
?>
		</table>
<?php
		}
		//Menu uniquement pour les admins
		if ($paramtype=='menu' AND $_SESSION['admingroupe']=="*"){
?>		
		<button type="button" onclick="document.location.href='adminmenu.php';">Nouveau menu</button>
<?php	
		$reponsemenu = $bdd->prepare('SELECT * FROM menu ORDER BY colonne, ligne');
		$reponsemenu->execute();
?>
		<table>
		<tr>
			<th>Actif</th>
			<th>Type</th>
			<th>Page</th>
			<th>Titre</th>
			<th>Langue</th>
			<th>Colonne</th>
			<th>Ligne</th>
			<th>&nbsp;</th>
		</tr>
<?php			
		while ($donneesmenu = $reponsemenu->fetch()){
?>
			<tr>
			<td><?php echo htmlspecialchars($donneesmenu['actif']); ?></td>
			<td><?php echo htmlspecialchars($donneesmenu['type']); ?></td>
			<td><?php echo htmlspecialchars($donneesmenu['page']); ?></td>
			<td><?php echo htmlspecialchars($donneesmenu['titre']); ?></td>
			<td><?php echo htmlspecialchars($donneesmenu['langue']); ?></td>
			<td><?php echo htmlspecialchars($donneesmenu['colonne']); ?></td>
			<td><?php echo htmlspecialchars($donneesmenu['ligne']); ?></td>
			<td><a href="adminmenu.php?id=<?php echo $donneesmenu['id']; ?>">Gerer le menu</a></td>
			</tr>
<?php
		}
		$reponsemenu->closeCursor(); // Termine le traitement de la requête
?>
		</table>
<?php
		}
		//Evénement pour les administrateur d'événement
		if ($paramtype=='evenement' AND $_SESSION['adminevenement']==1){
?>	
		<button type="button" onclick="document.location.href='adminevenement.php';">Nouvel événement</button>
<?php	
		$reponseevenement = $bdd->prepare('SELECT * FROM evenement');
		$reponseevenement->execute();
?>
		<table>
		<tr>
			<th>Titre</th>
			<th>Libellé</th>
			<th>Langue</th>
			<th>Date de début</th>
			<th>Date de fin</th>
			<th>&nbsp;</th>
		</tr>
<?php			
		while ($donneesevenement = $reponseevenement->fetch()){
			if ($_SESSION['admingroupe']=="*" OR $_SESSION['admingroupe']==$donneesevenement['admingroupe']){
?>
			<tr>
			<td><?php echo htmlspecialchars($donneesevenement['titre']); ?></td>
			<td><?php echo htmlspecialchars($donneesevenement['libelle']); ?></td>
			<td><?php echo htmlspecialchars($donneesevenement['langue']); ?></td>
			<td><?php echo htmlspecialchars($donneesevenement['datedeb']); ?></td>
			<td><?php echo htmlspecialchars($donneesevenement['datefin']); ?></td>
			<td><a href="adminevenement.php?id=<?php echo $donneesevenement['id']; ?>">Gerer l'evenement</a></td>
			</tr>
<?php
			}
		}
		$reponseevenement->closeCursor(); // Termine le traitement de la requête
?>
		</table>
<?php
		}
		//Réseration pour les administrateurs de réservation
		if ($paramtype=='reservation' AND $_SESSION['adminreservation']==1){
?>	
		<button type="button" onclick="document.location.href='adminreservation.php';">Nouvelle réservation</button>
<?php	
		$reponsereservation = $bdd->prepare('SELECT * FROM reservation');
		$reponsereservation->execute();
?>
		<table>
		<tr>
			<th>Nom</th>
			<th>Date de réservation</th>
			<th>Etat</th>
			<th>&nbsp;</th>
		</tr>
<?php			
		while ($donneesreservation = $reponsereservation->fetch()){
			if ($_SESSION['admingroupe']=="*" OR $_SESSION['admingroupe']==$donneesreservation['admingroupe']){
?>
			<tr>
			<td><?php echo htmlspecialchars($donneesreservation['nom']); ?></td>
			<td><?php echo htmlspecialchars($donneesreservation['datres']); ?></td>
			<td><?php echo htmlspecialchars($donneesreservation['etat']); ?></td>
			<td><a href="adminreservation.php?id=<?php echo $donneesreservation['id']; ?>">Gerer la réservation</a></td>
			</tr>
<?php
			}
		}
		$reponsereservation->closeCursor(); // Termine le traitement de la requête
?>
		</table>
		<?php
		}
		//Contenu pour les administrateurs de messagerie
		if ($paramtype=='contenu' AND $_SESSION['admincontenu']==1){
?>	
		<button type="button" onclick="document.location.href='admincontenu.php';">Nouveau contenu</button>
<?php	
		$reponsecontenu = $bdd->prepare('SELECT * FROM contenu ORDER BY page, emplacement');
		$reponsecontenu->execute();
?>
		<table>
		<tr>
			<th>Titre</th>
			<th>Langue</th>
			<th>Page</th>
			<th>Emplacement</th>
			<th>Publié</th>
			<th>Ordre</th>
			<th>Mail</th>
			<th>Tel</th>
			<th>&nbsp;</th>
		</tr>
<?php			
		while ($donneescontenu = $reponsecontenu->fetch()){
			if ($_SESSION['admingroupe']=="*" OR $_SESSION['admingroupe']==$donneescontenu['admingroupe']){
?>
			<tr>
			<td><?php echo htmlspecialchars($donneescontenu['titre']); ?></td>
			<td><?php echo htmlspecialchars($donneescontenu['langue']); ?></td>
			<td><?php echo htmlspecialchars($donneescontenu['page']); ?></td>
			<td><?php echo htmlspecialchars($donneescontenu['emplacement']); ?></td>
			<td><?php echo htmlspecialchars($donneescontenu['adminpublication']); ?></td>
			<td><?php echo htmlspecialchars($donneescontenu['ordre']); ?></td>
			<td><?php echo htmlspecialchars($donneescontenu['mail']); ?></td>
			<td><?php echo htmlspecialchars($donneescontenu['tel']); ?></td>
			<td><a href="admincontenu.php?id=<?php echo $donneescontenu['id']; ?>">Gérer le contenu</a></td>
			</tr>
<?php
			}
		}
		$reponsecontenu->closeCursor(); // Termine le traitement de la requête
?>
		</table>
<?php
		}
		//Langue uniquement pour les admins
		if ($paramtype=='langue' AND $_SESSION['admingroupe']=="*"){
?>
		<!--<button type="button" onclick="document.location.href='adminLangue.php';">Nouvelle Langue</button>-->
<?php	
		$reponselangue = $bdd->prepare('SELECT * FROM langue');
		$reponselangue->execute();
?>
		<table>
		<tr>
			<th>Langue</th>
			<!--<th>&nbsp;</th>-->
		</tr>
<?php			
		while ($donneeslangue = $reponselangue->fetch()){
?>
			<tr>
			<td><?php echo htmlspecialchars($donneeslangue['langue']); ?></td>
			<!--<td><a href="adminlangue.php?langue=<?php echo $donneeslangue['langue']; ?>">Gerer la langue</a></td>-->
			</tr>
<?php
		}
		$reponselangue->closeCursor(); // Termine le traitement de la requête
?>
		</table>
<?php
		}
		//Utilisateur uniquement pour les admins
		if ($paramtype=='utilisateur' AND $_SESSION['admingroupe']=="*"){
?>
		<!--<button type="button" onclick="document.location.href='adminUtilisateur.php';">Nouvel utilisateur</button>-->
<?php	
		$reponseutilisateur = $bdd->prepare('SELECT * FROM utilisateur');
		$reponseutilisateur->execute();
?>
		<table>
		<tr>
			<th>Utilisateur</th>
			<!--<th>&nbsp;</th>-->
		</tr>
<?php			
		while ($donneesutilisateur = $reponseutilisateur->fetch()){
?>
			<tr>
			<td><?php echo htmlspecialchars($donneesutilisateur['login']); ?></td>
			<!--<td><a href="adminutilisateur.php?login=<?php echo $donneesutilisateur['login']; ?>">Gerer l'utilisateur</a></td>-->
			</tr>
<?php
		}
		$reponseutilisateur->closeCursor(); // Termine le traitement de la requête
?>
		</table>
<?php
		}
}
?>
        </form>
    </body>
<?php include("foot.php"); ?>
</html>