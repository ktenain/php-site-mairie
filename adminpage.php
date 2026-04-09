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
       <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
			<h1>Gestion d'une page</h1>
			<p><button type="submit" formaction="admin.php?type=page">Retour</button></p>
<?php include("loginsaisie.php"); ?>
<?php
	if (isset($_SESSION['login'])){

	$okMaj=false;
	/*Validation du formulaire*/
	if ($_SERVER["REQUEST_METHOD"] == "POST") {

		if (isset($_POST['page']) AND isset($_POST['libelle'])){
			if (!empty($_POST["page"]) AND !empty($_POST["libelle"])) {
				$okMaj=true;
				if (isset($_POST['presentation']))
					$presentation = $_POST['presentation']; // equals 1 since that's the given value
				else
					$presentation = '';
				if (isset($_POST['evenement']))
					$evenement = $_POST['evenement']; // equals 1 since that's the given value
				else
					$evenement = 0;
				if (isset($_POST['reservation']))
					$reservation = $_POST['reservation']; // equals 1 since that's the given value
				else
					$reservation = 0;
				if (isset($_POST['evtrecent']))
					$evtrecent = $_POST['evtrecent']; // equals 1 since that's the given value
				else
					$evtrecent = 0;
				if (isset($_POST['btajouter'])) {
					$req = $bdd->prepare('INSERT INTO page(page, libelle, presentation, evenement, reservation, evtrecent) VALUES(:page, :libelle, :presentation, :evenement, :reservation, :evtrecent)');
					$req->execute(array(
						'page' => $_POST['page'],
						'libelle' => $_POST['libelle'],
						'evenement' => $evenement,
						'presentation' => $presentation,
						'reservation' => $reservation,
						'evtrecent' => $evtrecent
						));
					$req->closeCursor(); // Termine le traitement de la requête
					echo("<p>Ajout terminé</p>");
				}else if (isset($_POST['btmodifier']) AND isset($_POST['id'])) {
					$req = $bdd->prepare('UPDATE page SET page=:page, libelle=:libelle, presentation=:presentation, evenement=:evenement, reservation=:reservation, evtrecent=:evtrecent WHERE id=:id');
					$req->execute(array(
					':page' => $_POST['page'],
					':libelle' => $_POST['libelle'],
					':presentation' => $presentation,
					':evenement' => $evenement,
					':reservation' => $reservation,
					':evtrecent' => $evtrecent,
					':id' => intval($_POST['id'])
					));
					$req->closeCursor(); // Termine le traitement de la requête
					echo("<p>Modification terminée</p>");
				}else if (isset($_POST['btsupprimer']) AND isset($_POST['id'])) {
					//Quand suppression d'une page, on sésactive le menu qui la lance et on enlève la page des contenus
					$req = $bdd->prepare('UPDATE menu SET page="", actif=0 WHERE page=:page');
					$req->execute(array(
						':page' => $_POST['page'],
					));
					$req->closeCursor(); // Termine le traitement de la requête
					$req = $bdd->prepare('UPDATE contenu SET page="", emplacement="" WHERE page=:page');
					$req->execute(array(
						':page' => $_POST['page'],
					));
					$req->closeCursor(); // Termine le traitement de la requête					
					$req = $bdd->prepare("DELETE FROM page WHERE id=:id");
					$req->execute(array(
					':id' => intval($_POST['id']))
					);
					$req->closeCursor();// Termine le traitement de la requête
					echo("<p>Suppression terminée</p>");
				}else{
?>
					<p>Vous devez cliquer sur un bouton pour connaitre l'action à réaliser</p>
<?php					
				}
			}
		}
	}
	
	/*Validation du formulaire*/
	if ($okMaj==false){
		
		$id="";
		$page="";
		$libelle="";
		$presentation="";
		$evenement="";
		$reservation="";
		$evtrecent="";

		$pageErr="";
		$libelleErr="";
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			$id=$_POST['id'];
			if (isset($_POST['page'])){
				if (empty($_POST["page"])) {
					$pageErr = "Page obligatoire";
				}else{
					$page=$_POST['page'];
				}
			}
			if (isset($_POST['libelle'])){
				if (empty($_POST["libelle"])) {
					$libelleErr = "Libellé obligatoire";
				}else{
					$libelle=$_POST['libelle'];
				}
			}
			$presentation=$_POST['presentation'];
			$evenement=$_POST['evenement'];
			$reservation=$_POST['reservation'];
			$evtrecent=$_POST['evtrecent'];
		}
		if (isset($_GET['id'])){
			$reponsepage = $bdd->prepare('SELECT * FROM page WHERE id=:id');
			$reponsepage->execute(array('id' => $_GET['id']));
			while ($donneespage = $reponsepage->fetch()){
				$id=$donneespage['id'];
				$page=$donneespage['page'];
				$libelle=$donneespage['libelle'];
				$presentation=$donneespage['presentation'];
				$evenement=$donneespage['evenement'];
				$reservation=$donneespage['reservation'];
				$evtrecent=$donneespage['evtrecent'];
			}
			$reponsepage->closeCursor(); // Termine le traitement de la requête
		}
?>
			<p><label for="id">Id :</label><input type="number" name="id" id="id" value="<?php echo $id;?>" readonly></p>
			<p><label for="page">Identifiant de page :</label><input type="text" name="page" id="page" size="15" value="<?php echo $page;?>" <?php if ($page=="accueil"){?> readonly <?php } ?>><span class="error">* <?php echo $pageErr;?></span></p>
			<p><label for="libelle">libelle :</label><input type="text" name="libelle" id="libelle" size="25" value="<?php echo $libelle;?>"><span class="error">* <?php echo $libelleErr;?></span></p>
			<p><input type="checkbox" name="evenement" id="evenement" value="1" <?php if($evenement==1) echo "checked"; ?>>Evènement</p>
			<p></select>
			<label for="page">Présentation :</label><select name="presentation" size="1">
			<option value="" <?php if($presentation=="") echo "selected"; ?>>Aucune
			<option value="12" <?php if($presentation=='12') echo "selected"; ?>>12
			<option value="84" <?php if($presentation=='84') echo "selected"; ?>>84
			<option value="66" <?php if($presentation=='66') echo "selected"; ?>>66
			<option value="48" <?php if($presentation=='48') echo "selected"; ?>>48
			<option value="444" <?php if($presentation=='444') echo "selected"; ?>>444
			</select></p>
			<p><input type="checkbox" name="reservation" id="reservation" value="1" <?php if($reservation==1) echo "checked"; ?>>Réservation</p>
			<p><input type="checkbox" name="evtrecent" id="evtrecent" value="1" <?php if($evtrecent==1) echo "checked"; ?>>Evénements récents</p>
<?php
		if (isset($_GET['id'])){
?>
			<p><button type="submit" name="btmodifier">Modifier</button>
			<?php if ($page!=="accueil"){?>
			<button type="submit" name="btsupprimer">Supprimer</button>
			<?php } ?>
			</p>
<?php
		}else{
?>			
			<p><button type="submit" name="btajouter">Ajouter</button></p>
<?php
		}
	}
}
?>
        </form>
    </body>
<?php include("foot.php"); ?>
</html>