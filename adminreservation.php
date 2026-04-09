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
			<h1>Gérer une réservation</h1>
			<p><button type="submit" formaction="admin.php?type=reservation">Retour</button></p>
<?php include("loginsaisie.php"); ?>
<?php
	if (isset($_SESSION['login'])){

	$okMaj=false;
	/*Mise à jour du formulaire */
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
			if (isset($_POST['ressource']) AND isset($_POST['nom']) AND isset($_POST['datres'])){

			if (!empty($_POST["ressource"]) AND !empty($_POST["nom"]) AND !empty($_POST["datres"])) {
				if (empty($_POST["commentaire"]) ){
					$commentaire="";
				}else{
					$commentaire=$_POST["commentaire"];
				}
				if (empty($_POST["etat"]) ){
					$etat="att";
				}else{
					$etat=$_POST["etat"];
				}
				$okMaj=true;
				if (isset($_POST['btajouter'])) {
					$req = $bdd->prepare('INSERT INTO reservation(ressource, nom, datres, etat, commentaire) VALUES(:ressource, :nom, :datres, :etat, :commentaire)');
					$req->execute(array(
						'ressource' => $_POST['ressource'],
						'nom' => $_POST['nom'],
						'datres' => date("Y-m-d", strtotime(str_replace('/', '-',$_POST['datres']))),
						'etat' => $etat,
						'commentaire' => $commentaire
						));
					$req->closeCursor(); // Termine le traitement de la requête
					echo("<p>Ajout terminé</p>");
				}else if (isset($_POST['btmodifier']) AND isset($_POST['id'])) {
					$req = $bdd->prepare('UPDATE reservation SET ressource=:ressource, nom=:nom, datres=:datres, etat=:etat, commentaire=:commentaire WHERE id=:id');
					$req->execute(array(
						':ressource' => $_POST['ressource'],
						':nom' => $_POST['nom'],
						':datres' => date("Y-m-d", strtotime(str_replace('/', '-',$_POST['datres']))),
						':etat' => $etat,
						':commentaire' => $commentaire,
						':id' => intval($_POST['id'])
						));
					$req->closeCursor(); // Termine le traitement de la requête
					echo("<p>Modification terminée</p>");
				}else if (isset($_POST['btsupprimer']) AND isset($_POST['id'])) {
					$req = $bdd->prepare("DELETE FROM reservation WHERE id=:id");
					$req->execute(array(
						':id' => intval($_POST['id'])));
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
	$ressource="";
	$nom="";
	$datres="";
	$etat="";
	$commentaire="";

	$ressourceErr="";
	$nomErr="";
	$datresErr="";
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$id=$_POST['id'];
		if (isset($_POST['ressource'])){
			if (empty($_POST["ressource"])) {
				$ressourceErr = "Ressource obligatoire";
			}else{
				$ressource=$_POST['ressource'];
			}
		}
		if (isset($_POST['nom'])){
			if (empty($_POST["nom"])) {
				$nomErr = "Nom obligatoire";
			}else{
				$nom=$_POST['nom'];
			}
		}
		if (isset($_POST['datres'])){
			if (empty($_POST["datres"])) {
				$datresErr = "Date de réservation obligatoire";
			}else{
				$datres=$_POST['datres'];
			}
		}
		$commentaire=$_POST['commentaire'];
	}
	/*Affichage des zones de saisies en modification et suppression*/
	if (isset($_GET['id'])){
		$reponseevenement = $bdd->prepare('SELECT * FROM reservation WHERE id=:id');
		$reponseevenement->execute(array('id' => $_GET['id']));
		while ($donneesevenement = $reponseevenement->fetch()){
			$id=$donneesevenement['id'];
			$ressource=$donneesevenement['ressource'];
			$nom=$donneesevenement['nom'];
			$date = date_create($donneesevenement['datres']);
			$datres=date_format($date, 'd/m/Y');
			$etat=$donneesevenement['etat'];
			$commentaire=$donneesevenement['commentaire'];
		}
		$reponseevenement->closeCursor(); // Termine le traitement de la requête
	}
?>
			<p><label for="id">Id :</label><input type="number" name="id" id="id" value="<?php echo $id;?>" readonly></p>
<?php
			$reponseressource = $bdd->prepare('SELECT * FROM ressource');
			$reponseressource->execute();
?>
			<p><label for="ressource">Ressource :</label><select name="ressource" size="1">
			<option value="" <?php if($ressource=="") echo "selected"; ?>>Aucune
<?php			
			while ($donneesressource = $reponseressource->fetch()){
?>
				<option value="<?php echo $donneesressource['id']; ?>" <?php if($ressource==$donneesressource['id']) echo "selected"; ?>><?php echo $donneesressource['nom']; ?>
<?php
			}
?>
			</select><span class="error">* <?php echo $ressourceErr;?></span></p>
<?php		
			$reponseressource->closeCursor(); // Termine le traitement de la requête
?>			
			<p><label for="nom">Nom :</label><input type="text" name="nom" id="nom" size="30" value="<?php echo $nom;?>"><span class="error">* <?php echo $nomErr;?></span></p>
			<p><label for="commentaire">Commentaire :</label><textarea name="commentaire" id="commentaire" rows="10" cols="80">
			<?php echo $commentaire;?>
			</textarea></p>
			<script>CKEDITOR.replace( 'commentaire' );</script>
			<p><label for="datres">Date de réservation :</label><input type="date" name="datres" id="datres" maxlength="10" size="10" value="<?php echo $datres;?>"><span class="error">* <?php echo $datresErr;?></span></p>
			<p><label for="etat">Etat :</label>
			<select name="etat" size="1" <?php if ($_SESSION['admingroupe']!=="*") echo "disabled" ?>>
				<option value="att" <?php if($etat=="att") echo "selected"; ?>>En attente de confirmation
				<option value="con" <?php if($etat=="con") echo "selected"; ?>>Confirmé
			</select></p>
<?php			
		if (isset($_GET['id'])){
?>
			<p><button type="submit" name="btmodifier">Modifier</button><button type="submit" name="btsupprimer">Supprimer</button></p>
<?php
		}else{
?>			
			<p><button type="submit" name="btajouter">Ajouter</button></p>
<?php
		}
	}/*Fin pas de maj*/
}
?>
        </form>
    </body>
<?php include("foot.php"); ?>
</html>