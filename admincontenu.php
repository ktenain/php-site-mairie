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
			<h1>Gérer un contenu</h1>
			<p><button type="submit" formaction="admin.php?type=contenu">Retour</button></p>
<?php include("loginsaisie.php"); ?>
<?php
	if (isset($_SESSION['login'])){

	$okMaj=false;
	/*Mise à jour du formulaire */
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
			if (isset($_POST['titre']) AND isset($_POST['contenu']) AND isset($_POST['emplacement']) AND isset($_POST['langue']) ){

			if (!empty($_POST["titre"]) AND !empty($_POST["contenu"]) AND !empty($_POST["emplacement"]) AND !empty($_POST["langue"]) ) {
				if (empty($_POST["page"]) ){
					$page="";
				}else{
					$page=$_POST["page"];
				}
				if (isset($_POST['adminpublication']))
					$adminpublication = $_POST['adminpublication']; // equals 1 since that's the given value
				else
					$adminpublication = 0;

				$okMaj=true;
				if (isset($_POST['btajouter'])) {
					$req = $bdd->prepare('INSERT INTO contenu(titre, contenu, page, emplacement, adminpublication, langue) VALUES(:titre, :contenu, :page, :emplacement, :adminpublication, :langue)');
					$req->execute(array(
						'titre' => $_POST['titre'],
						'contenu' => $_POST['contenu'],
						'page' => $page,
						'emplacement' => $_POST['emplacement'],
						'adminpublication' => $adminpublication,
						'langue' => $_POST['langue'],
						));
					$req->closeCursor(); // Termine le traitement de la requête
					echo("<p>Ajout terminé</p>");
				}else if (isset($_POST['btmodifier']) AND isset($_POST['id'])) {
					$req = $bdd->prepare('UPDATE contenu SET titre=:titre, contenu=:contenu, page=:page, emplacement=:emplacement, adminpublication=:adminpublication,  langue=:langue WHERE id=:id');
					$req->execute(array(
						':titre' => $_POST['titre'],
						':contenu' => $_POST['contenu'],
						':page' => $page,
						':emplacement' => $_POST['emplacement'],
						':adminpublication' => $adminpublication,
						':langue' => $_POST['langue'],
						':id' => intval($_POST['id'])
						));
					$req->closeCursor(); // Termine le traitement de la requête
					echo("<p>Modification terminée</p>");
				}else if (isset($_POST['btsupprimer']) AND isset($_POST['id'])) {
					$req = $bdd->prepare("DELETE FROM contenu WHERE id=:id");
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
	$titre="";
	$contenu="";
	$page="";
	$emplacement="";
	$adminpublication="";
	$langue="";

	$titreErr="";
	$contenuErr="";
	$pageErr="";
	$emplacementErr="";
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$id=$_POST['id'];
		if (isset($_POST['titre'])){
			if (empty($_POST["titre"])) {
				$titreErr = "Titre obligatoire";
			}else{
				$titre=$_POST['titre'];
			}
		}
		if (isset($_POST['contenu'])){
			if (empty($_POST["contenu"])) {
				$contenuErr = "Contenu obligatoire";
			}else{
				$contenu=$_POST['contenu'];
			}
		}
		$page=$_POST['page'];
		if (isset($_POST['emplacement'])){
			if (empty($_POST["emplacement"])) {
				$emplacementErr = "Emplacement obligatoire";
			}else{
				$emplacement=$_POST['emplacement'];
			}
		}
		$adminpublication=$_POST['adminpublication'];
		$langue=$_POST['langue'];
	}
	/*Affichage des zones de saisies en modification et suppression*/
	if (isset($_GET['id'])){
		$reponsecontenu = $bdd->prepare('SELECT * FROM contenu WHERE id=:id');
		$reponsecontenu->execute(array('id' => $_GET['id']));
		while ($donneescontenu = $reponsecontenu->fetch()){
			$id=$donneescontenu['id'];
			$titre=$donneescontenu['titre'];
			$contenu=$donneescontenu['contenu'];
			$page=$donneescontenu['page'];
			$emplacement=$donneescontenu['emplacement'];
			$adminpublication=$donneescontenu['adminpublication'];
			$langue=$donneescontenu['langue'];
		}
		$reponsecontenu->closeCursor(); // Termine le traitement de la requête
	}
	if (isset($_GET['page'])){
		$page=$_GET['page'];
	}
	if (isset($_GET['emplacement'])){
		$emplacement=$_GET['emplacement'];
	}
	if (isset($_GET['langue'])){
		$langue=$_GET['langue'];
	}
?>
			<p><label for="id">Id :</label><input type="number" name="id" id="id" value="<?php echo $id;?>" readonly></p>
			<p><label for="titre">Titre :</label><input type="text" name="titre" id="titre" size="50" value="<?php echo $titre;?>"><span class="error">* <?php echo $titreErr;?></span></p>
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
			<p><label for="emplacement">Emplacement :</label>
			<select name="emplacement" size="1">
				<option value=""<?php if($emplacement=="") echo "selected"; ?>>
				<option value="alerte"<?php if($emplacement=="alerte") echo "selected"; ?>>Alerte
				<option value="gauche"<?php if($emplacement=="gauche") echo "selected"; ?>>Gauche
				<option value="milieu"<?php if($emplacement=="milieu") echo "selected"; ?>>Milieu
				<option value="droite"<?php if($emplacement=="droite") echo "selected"; ?>>Droite
			</select><span class="error">* <?php echo $emplacementErr;?></span></p>
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
			<p><label for="contenu">Contenu :</label><textarea name="contenu" id="contenu" rows="10" cols="80">
			<?php echo $contenu;?>
			</textarea><span class="error">* <?php echo $contenuErr;?></span></p>
			<script>CKEDITOR.replace( 'contenu' );</script>
			<p><input type="checkbox" name="adminpublication" id="adminpublication" value="1" <?php if($adminpublication==1) echo "checked"; ?>>Publié</p>

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