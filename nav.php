        <nav class="navbar navbar-inverse">
			<ul id="menu" class="nav navbar-nav">
		<?php
		$oldType="";
		$reponsemenu = $bdd->prepare('SELECT * FROM menu WHERE langue=:langue ORDER BY colonne, ligne');
		$reponsemenu->execute(array('langue' => $paramlangue));
		while ($donneesmenu = $reponsemenu->fetch()){
		if (!isset($oldCol)) $oldCol = $donneesmenu['colonne'];
		if (!isset($oldLig)) $oldLig = $donneesmenu['ligne'];
		if (!isset($oldType)) $oldType = "menu";
		//Si menu
		if ($donneesmenu['type'] == "menu"){
			if ($oldType == "sousmenu"){
			?>
			</ul></li>
			<?php
			}if ($oldType == "menu"){
			?>
			</li>
			<?php
			}
			?>
			<li>
			<?php if ($donneesmenu['page']!==""){ ?>
				<?php if ($parammode=="brouillon"){ ?>
					<a href="page.php?mode=<?php echo $parammode; ?>&page=<?php echo $donneesmenu['page']; ?>"><?php echo htmlspecialchars($donneesmenu['titre']); ?></a>
				<?php }else{ ?>
					<a href="page.php?page=<?php echo $donneesmenu['page']; ?>"><?php echo htmlspecialchars($donneesmenu['titre']); ?></a>
				<?php } ?>
			<?php }else{ ?>
				<a href="#"><?php echo htmlspecialchars($donneesmenu['titre']); ?></a>
			<?php
			}
		}
		//Si sous menu
		if ($donneesmenu['type'] == "sousmenu"){
			if ($oldType == "menu"){
			?>
			<ul>
			<?php
			}
			?>
			<li>
			<?php if ($donneesmenu['page']!==""){ ?>
				<?php if ($parammode=="brouillon"){ ?>
					<a href="page.php?mode=<?php echo $parammode; ?>&page=<?php echo $donneesmenu['page']; ?>"><?php echo htmlspecialchars($donneesmenu['titre']); ?></a>
				<?php }else{ ?>
					<a href="page.php?page=<?php echo $donneesmenu['page']; ?>"><?php echo htmlspecialchars($donneesmenu['titre']); ?></a>
				<?php } ?>
			<?php }else{ ?>
				<a href="#"><?php echo htmlspecialchars($donneesmenu['titre']); ?></a>
			<?php
			}
			?>
			</li>
		<?php			
		}
		$oldCol = $donneesmenu['colonne'];
		$oldLig = $donneesmenu['ligne'];
		$oldType = $donneesmenu['type'];
		}
		$reponsemenu->closeCursor(); // Termine le traitement de la requête
		//Si on a terminé par un sous menu...
		if ($oldType == "sousmenu"){
		?>
		</ul>
		<?php
		}
				//fin menu
		?>
				</li>
			</ul>
			<ul class="nav navbar-nav navbar-right">
			<?php if ($paramelem=="page"){
		$reponselangue = $bdd->prepare('SELECT * FROM langue WHERE adminpublication=1');
		$reponselangue->execute();
		while ($donneeslangue = $reponselangue->fetch()){
?>
			<li><a href="page.php?mode=<?php echo $parammode ?>&page=<?php echo $parampage ?>&langue=<?php echo htmlspecialchars($donneeslangue['langue']) ?>"><img title="<?php echo htmlspecialchars($donneeslangue['langue']); ?>" width="16" height="16" alt="<?php echo htmlspecialchars($donneeslangue['langue']); ?>" src="images/drapeau<?php echo htmlspecialchars($donneeslangue['langue']); ?>.png"></a></li>
<?php
		}
		$reponselangue->closeCursor(); // Termine le traitement de la requête
?>
		<?php } ?>
		
		<?php if (isset($_SESSION['login'])){?>
			<li><a href="fonctions/deconnexion.php"><img src="images/logout.png" width="16" height="16" alt="Déconnexion" title="Déconnexion"></a></li>
		<?php } ?>
		
		<?php if ($paramelem=="page"){ ?>
		<?php if (isset($_SESSION['login'])){?>
			<?php if ($_SESSION['admingroupe']=="*"){ ?>
				<li><a href="page.php?mode=public&page=<?php echo $parampage ?>&langue=<?php echo $paramlangue ?>"><img src="images/public.png" width="16" height="16" alt="Public" title="Public"></a></li>
				<li><a href="page.php?mode=brouillon&page=<?php echo $parampage ?>&langue=<?php echo $paramlangue ?>"><img src="images/brouillon.png" width="16" height="16" alt="Brouillon" title="Brouillon"></a></li>
			<?php } ?>
		<?php } ?>
		<?php } ?>
			</ul>
        </nav>