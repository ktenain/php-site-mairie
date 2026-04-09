		<?php
		if ($parampage=="accueil"){
		?>
<div class="contenuv"><marquee direction="up" scrollamount="2" height="100">
		<?php
	//Si on est logué...
	if (isset($_SESSION['login'])){
		//Si mode brouillon
		if ($parammode=="brouillon"){
			$reponseevenement = $bdd->prepare('SELECT `titre`, `libelle` FROM `evenement` WHERE `datefin`>=CURDATE() ORDER BY `datefin`');
		}else{
		//Sinon mode public
			$reponseevenement = $bdd->prepare('SELECT `titre`, `libelle` FROM `evenement` WHERE `datefin`>=CURDATE() AND adminpublication=1 ORDER BY `datefin`');
		}
	}else{
		$reponseevenement = $bdd->prepare('SELECT `titre`, `libelle` FROM `evenement` WHERE `datefin`>=CURDATE() AND adminpublication=1 ORDER BY `datefin`');
	}
		$reponseevenement->execute();
		?>
		<?php
		$i=0; 
		while ($donneesevenement = $reponseevenement->fetch()){
			++$i;
			if ($i==1){
		?>
			<?php
			}
			?>
		<p class="titrev"><?php echo htmlspecialchars($donneesevenement['titre']); ?></p>
		<p<?php echo $donneesevenement['libelle']; ?></p>
		<?php
		}
		?>
</marquee></div>
		<?php                
		$reponseevenement->closeCursor(); // Termine le traitement de la requête
}
		?>