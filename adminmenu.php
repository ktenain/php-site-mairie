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
			<h1>Gérer un menu</h1>
			<p><button type="submit" formaction="admin.php?type=menu">Retour</button></p>
<?php include("loginsaisie.php"); ?>
<?php
	if (isset($_SESSION['login'])){

	$okMaj=false;
	/*Mise à jour du formulaire */
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		if (isset($_POST['type']) AND isset($_POST['titre']) AND isset($_POST['page']) AND isset($_POST['colonne']) AND isset($_POST['ligne'])){
			if (!empty($_POST["type"]) AND !empty($_POST["titre"])) {
				if (empty($_POST["page"]) ){
					$page="";
				}else{
					$page=$_POST["page"];
				}
				if (empty($_POST["ligne"]) ){
					$ligne="";
				}else{
					$ligne=$_POST["ligne"];
				}
				if (empty($_POST["colonne"]) ){
					$colonne="";
				}else{
					$colonne=$_POST["colonne"];
				}
				if (empty($_POST["langue"]) ){
					$langue="Fr";
				}else{
					$langue=$_POST["langue"];
				}
				
				$okMaj=true;
				if (isset($_POST['btajouter'])) {
					$req = $bdd->prepare('INSERT INTO menu(type, titre, page, colonne, ligne, langue) VALUES(:type, :titre, :page, :colonne, :ligne, :langue)');
					$req->execute(array(
						'type' => $_POST['type'],
						'titre' => $_POST['titre'],
						'page' => $page,
						'colonne' => $colonne,
						'ligne' => $ligne,
						'langue' => $langue
						));
					$req->closeCursor(); // Termine le traitement de la requête
					echo("<p>Ajout terminé</p>");
				}else if (isset($_POST['btmodifier']) AND isset($_POST['id'])) {
					$req = $bdd->prepare('UPDATE menu SET type=:type, titre=:titre, page=:page, colonne=:colonne, ligne=:ligne, langue=:langue WHERE id=:id');
					$req->execute(array(
						':type' => $_POST['type'],
						':titre' => $_POST['titre'],
						':page' => $_POST['page'],
						':colonne' => $_POST['colonne'],
						':ligne' => $_POST['ligne'],
						':langue' => $_POST['langue'],
						':id' => intval($_POST['id'])
					));
					$req->closeCursor(); // Termine le traitement de la requête
					echo("<p>Modification terminée</p>");
						
				}else if (isset($_POST['btsupprimer']) AND isset($_POST['id'])) {
					$req = $bdd->prepare("DELETE FROM menu WHERE id=:id");
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
	$type="";
	$titre="";
	$page="";
	$colonne="";
	$ligne="";
	$langue="";

	$typeErr="";
	$titreErr="";
	$pageErr="";
	$colonneErr="";
	$ligneErr="";
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$id=$_POST['id'];
		if (isset($_POST['type'])){
			if (empty($_POST["type"])) {
				$typeErr = "Type obligatoire";
			}else{
				$type=$_POST['type'];
			}
		}
		if (isset($_POST['titre'])){
			if (empty($_POST["titre"])) {
				$titreErr = "Titre obligatoire";
			}else{
				$titre=$_POST['titre'];
			}
		}
		$page=$_POST['page'];
		$colonne=$_POST['colonne'];
		$ligne=$_POST['ligne'];
		$langue=$_POST['langue'];
	}
	/*Affichage des zones de saisies en modification et suppression*/
	if (isset($_GET['id'])){
		$reponsemenu = $bdd->prepare('SELECT * FROM menu WHERE id=:id');
		$reponsemenu->execute(array('id' => $_GET['id']));
		while ($donneesmenu = $reponsemenu->fetch()){
			$id=$donneesmenu['id'];
			$type=$donneesmenu['type'];
			$titre=$donneesmenu['titre'];
			$page=$donneesmenu['page'];
			$colonne=$donneesmenu['colonne'];
			$ligne=$donneesmenu['ligne'];
			$langue=$donneesmenu['langue'];
		}
		$reponsemenu->closeCursor(); // Termine le traitement de la requête
	}
?>
			<p><label for="id">Id :</label><input type="number" name="id" id="id" value="<?php echo $id;?>" readonly></p>
			<p><label for="type">Type :</label>
			<select name="type" size="1">
				<option value="menu" <?php if($type=="menu") echo "selected"; ?>>Menu
				<option value="sousmenu" <?php if($type=="sousmenu") echo "selected"; ?>>Sous-menu
			</select><span class="error">* <?php echo $typeErr;?></span></p>
			<p><label for="titre">Titre :</label><input type="text" name="titre" id="titre" value="<?php echo $titre;?>"><span class="error">* <?php echo $titreErr;?></span></p>
<?php
			$reponselangue = $bdd->prepare('SELECT * FROM langue');
			$reponselangue->execute();
?>
			<p><label for="langue">Langue :</label><select name="langue" size="1">
<?php			
			while ($donneeslangue = $reponselangue->fetch()){
?>
				<option value="<?php echo $donneeslangue['langue']; ?>" <?php if($langue==$donneeslangue['langue']) echo "selected"; ?>><?php echo $donneeslangue['langue']; ?>
<?php
			}
?>
			</select></p>
<?php
			$reponsepage = $bdd->prepare('SELECT * FROM page');
			$reponsepage->execute();
?>
			<p><label for="page">Page :</label><select name="page" size="1">
			<option value="" <?php if($page=="") echo "selected"; ?>>Aucune
<?php			
			while ($donneespage = $reponsepage->fetch()){
?>
				<option value="<?php echo $donneespage['page']; ?>" <?php if($page==$donneespage['page']) echo "selected"; ?>><?php echo $donneespage['libelle']; ?>
<?php
			}
?>
			</select></p>
<?php		
			$reponsepage->closeCursor(); // Termine le traitement de la requête
?>			
			<p><label for="colonne">Colonne :</label><input type="number" name="colonne" id="colonne" min="0" max="10" value="<?php echo $colonne;?>"></p>
			<p><label for="ligne">Ligne :</label><input type="number" name="ligne" id="ligne" min="0" max="10" value="<?php echo $ligne;?>"></p>
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
}/*fin mot de passe*/
?>
        </form>
    </body>
<?php include("foot.php"); ?>
</html>