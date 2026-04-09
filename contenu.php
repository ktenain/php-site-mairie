<?php
	$presentation='12';
	$reponsepage = $bdd->prepare('SELECT * FROM page WHERE page=:page');
	$reponsepage->execute(array('page' => $parampage));
	while ($donneespage = $reponsepage->fetch()){
		$presentation=$donneespage['presentation'];
if ($parammode=="brouillon"){ ?>
<a href="adminpage.php?id=<?php echo $donneespage['id']; ?>"><img src="images/editpage.png" width="16" height="16" alt="Modifier page" title="Modifier page"></a>
<?php }
	}
	$reponsepage->closeCursor(); // Termine le traitement de la requête
	?>
	<?php
if ($parammode=="brouillon"){ ?>
	<div class="row">
		<div class="col-sm-12">
		<div class="contenur">
		<a href="admincontenu.php?emplacement=alerte&page=<?php echo $parampage ?>&langue=<?php echo $paramlangue ?>"><img src="images/ajoutcontenu.png" width="16" height="16" alt="Ajouter contenu" title="Ajouter contenu"></a>
		</div></div>
	</div>
	<div class="row">
	<?php if ($presentation=='12' OR $presentation=='48' OR $presentation=='66' OR $presentation=='84' OR $presentation=='444'){?>
			<?php if ($presentation=='12'){ ?><div class="col-sm-12"><?php } ?>
			<?php if ($presentation=='48'){ ?><div class="col-sm-4"><?php } ?>
			<?php if ($presentation=='66'){ ?><div class="col-sm-6"><?php } ?>
			<?php if ($presentation=='84'){ ?><div class="col-sm-8"><?php } ?>
			<?php if ($presentation=='444'){ ?><div class="col-sm-4"><?php } ?>
			<div class="contenub">
			<a href="admincontenu.php?emplacement=gauche&page=<?php echo $parampage ?>&langue=<?php echo $paramlangue ?>"><img src="images/ajoutcontenu.png" width="16" height="16" alt="Ajouter contenu" title="Ajouter contenu"></a>
			</div></div>
	<?php }?>
	<?php if ($presentation=='444'){?>
			<div class="col-sm-4">
			<div class="contenuo">
			<a href="admincontenu.php?emplacement=milieu&page=<?php echo $parampage ?>&langue=<?php echo $paramlangue ?>"><img src="images/ajoutcontenu.png" width="16" height="16" alt="Ajouter contenu" title="Ajouter contenu"></a>
			</div></div>
	<?php }?>
	<?php if ($presentation=='48' OR $presentation=='66' OR $presentation=='84' OR $presentation=='444'){?>
			<?php if ($presentation=='48'){ ?><div class="col-sm-8"><?php } ?>
			<?php if ($presentation=='66'){ ?><div class="col-sm-6"><?php } ?>
			<?php if ($presentation=='84'){ ?><div class="col-sm-4"><?php } ?>
			<?php if ($presentation=='444'){ ?><div class="col-sm-4"><?php } ?>
			<div class="contenuv">
			<a href="admincontenu.php?emplacement=droite&page=<?php echo $parampage ?>&langue=<?php echo $paramlangue ?>"><img src="images/ajoutcontenu.png" width="16" height="16" alt="Ajouter contenu" title="ajouter contenu"></a>
			</div></div>
	<?php }?>
	</div>
<?php }?>
<?php
	//Si on est admin...
	if (isset($_SESSION['login'])){
		//Si mode brouillon
		if ($parammode=="brouillon"){
			$reponsealerte = $bdd->prepare('SELECT * FROM contenu WHERE emplacement="alerte" AND page=:page');
		}else{
		//Sinon mode public
			$reponsealerte = $bdd->prepare('SELECT * FROM contenu WHERE emplacement="alerte" AND adminpublication=1 AND page=:page');
		}
	}else{
		$reponsealerte = $bdd->prepare('SELECT * FROM contenu WHERE emplacement="alerte" AND adminpublication=1 AND page=:page');
	}
	$reponsealerte->execute(array('page' => $parampage));
	while ($donneesalerte = $reponsealerte->fetch()){
?>
<div class="row">
<div class="col-sm-12">
<div class="contenur">
<?php if ($parammode=="brouillon"){ ?>
<a href="admincontenu.php?id=<?php echo $donneesalerte['id']; ?>"><img src="images/editcontenu.png" width="16" height="16" alt="Modifier contenu" title="Modifier contenu"></a>
<?php } ?>
<p class="titrer"><?php echo htmlspecialchars($donneesalerte['titre']); ?></p>
<p><?php echo $donneesalerte['contenu']; ?></p>
</div></div></div>
<?php
	}
	$reponsealerte->closeCursor(); // Termine le traitement de la requête
?>
<div class="row">
<?php
	//Si on est admin...
	if (isset($_SESSION['login'])){
		//Si mode brouillon
		if ($parammode=="brouillon"){
			$reponsegauche = $bdd->prepare('SELECT * FROM contenu WHERE emplacement="gauche" AND page=:page');
			$reponsemilieu = $bdd->prepare('SELECT * FROM contenu WHERE emplacement="milieu" AND page=:page');
			$reponsedroite = $bdd->prepare('SELECT * FROM contenu WHERE emplacement="droite" AND page=:page');
		}else{
		//Sinon mode public
			$reponsegauche = $bdd->prepare('SELECT * FROM contenu WHERE emplacement="gauche" AND adminpublication=1 AND page=:page');
			$reponsemilieu = $bdd->prepare('SELECT * FROM contenu WHERE emplacement="milieu" AND adminpublication=1 AND page=:page');
			$reponsedroite = $bdd->prepare('SELECT * FROM contenu WHERE emplacement="droite" AND adminpublication=1 AND page=:page');
		}
	}else{
		$reponsegauche = $bdd->prepare('SELECT * FROM contenu WHERE emplacement="gauche" AND adminpublication=1 AND page=:page');
		$reponsemilieu = $bdd->prepare('SELECT * FROM contenu WHERE emplacement="milieu" AND adminpublication=1 AND page=:page');
		$reponsedroite = $bdd->prepare('SELECT * FROM contenu WHERE emplacement="droite" AND adminpublication=1 AND page=:page');
	}
	if ($presentation=='12' OR $presentation=='48' OR $presentation=='66' OR $presentation=='84' OR $presentation=='444'){
		$reponsegauche->execute(array('page' => $parampage));
		while ($donneesgauche = $reponsegauche->fetch()){
?>
			<?php if ($presentation=='12'){ ?><div class="col-sm-12"><?php } ?>
			<?php if ($presentation=='48'){ ?><div class="col-sm-4"><?php } ?>
			<?php if ($presentation=='66'){ ?><div class="col-sm-6"><?php } ?>
			<?php if ($presentation=='84'){ ?><div class="col-sm-8"><?php } ?>
			<?php if ($presentation=='444'){ ?><div class="col-sm-4"><?php } ?>
			<div class="contenub">
<?php if ($parammode=="brouillon"){ ?>
<a href="admincontenu.php?id=<?php echo $donneesgauche['id']; ?>"><img src="images/editcontenu.png" width="16" height="16" alt="Modifier contenu" title="Modifier contenu"></a>
<?php } ?>
			<p class="titreb"><?php echo htmlspecialchars($donneesgauche['titre']); ?></p>
			<p><?php echo $donneesgauche['contenu']; ?></p>
			</div></div>
<?php
		}
		$reponsegauche->closeCursor(); // Termine le traitement de la requête
	}
	if ($presentation=='444'){
		$reponsemilieu->execute(array('page' => $parampage));
		while ($donneesmilieu = $reponsemilieu->fetch()){
?>
			<div class="col-sm-4">
			<div class="contenuo">
<?php if ($parammode=="brouillon"){ ?>
<a href="admincontenu.php?id=<?php echo $donneesmilieu['id']; ?>"><img src="images/editcontenu.png" width="16" height="16" alt="Modifier contenu" title="Modifier contenu"></a>
<?php } ?>
			<p class="titreo"><?php echo htmlspecialchars($donneesmilieu['titre']); ?></p>
			<p><?php echo $donneesmilieu['contenu']; ?></p>
			</div></div>
<?php
		}
		$reponsemilieu->closeCursor(); // Termine le traitement de la requête
	}
	if ($presentation=='48' OR $presentation=='66' OR $presentation=='84' OR $presentation=='444'){
		$reponsedroite->execute(array('page' => $parampage));
		while ($donneesdroite = $reponsedroite->fetch()){
?>
			<?php if ($presentation=='48'){ ?><div class="col-sm-8"><?php } ?>
			<?php if ($presentation=='66'){ ?><div class="col-sm-6"><?php } ?>
			<?php if ($presentation=='84'){ ?><div class="col-sm-4"><?php } ?>
			<?php if ($presentation=='444'){ ?><div class="col-sm-4"><?php } ?>
			<div class="contenuv">
<?php if ($parammode=="brouillon"){ ?>
<a href="admincontenu.php?id=<?php echo $donneesdroite['id']; ?>"><img src="images/editcontenu.png" width="16" height="16" alt="Modifier contenu" title="Modifier contenu"></a>
<?php } ?>
			<p class="titrev"><?php echo htmlspecialchars($donneesdroite['titre']); ?></p>
			<p><?php echo $donneesdroite['contenu']; ?></p>
			</div></div>
<?php
		}
		$reponsedroite->closeCursor(); // Termine le traitement de la requête
	}
?>
</div></div>