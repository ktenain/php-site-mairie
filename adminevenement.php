<!DOCTYPE html>
<?php include("config.php"); ?>
<?php include("login.php"); ?>
<?php $paramelem="admin"; ?>
<html>
 <?php include("head.php"); ?>
<script>
$(function() {
$( "#datedeb" ).datepicker();
$( "#datefin" ).datepicker();
});
</script>
<!--[if IE6]><body class="ie6 old_ie"><![endif]-->
<!--[if IE7]><body class="ie7 old_ie"><![endif]-->
<!--[if IE8]><body class="ie8"><![endif]-->
<!--[if IE9]><body class="ie9"><![endif]-->
<!--[if !IE]><!--><body><!--<![endif]-->
       <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
			<h1>Gérer un évènement</h1>
			<p><button type="submit" formaction="admin.php?type=evenement">Retour</button></p>
<?php include("loginsaisie.php"); ?>
<?php
	if (isset($_SESSION['login'])){

	$okMaj=false;
	/*Mise à jour du formulaire */
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
			if (isset($_POST['titre']) AND isset($_POST['libelle']) AND isset($_POST['datedeb']) AND isset($_POST['datefin'])){

			if (!empty($_POST["titre"]) AND !empty($_POST["libelle"]) AND !empty($_POST["datedeb"]) AND !empty($_POST["datefin"])) {
				if (empty($_POST["email"]) ){
					$email="";
				}else{
					$email=$_POST["email"];
				}
				if (empty($_POST["tel"]) ){
					$tel="";
				}else{
					$tel=$_POST["tel"];
				}
				if (isset($_POST['adminpublication']))
					$adminpublication = $_POST['adminpublication']; // equals 1 since that's the given value
				else
					$adminpublication = 0;

				$okMaj=true;
				if (isset($_POST['btajouter'])) {
					$req = $bdd->prepare('INSERT INTO evenement(titre, libelle, datedeb, datefin, email, tel, adminpublication) VALUES(:titre, :libelle, :datedeb, :datefin, :email, :tel, :adminpublication)');
					$req->execute(array(
						'titre' => $_POST['titre'],
						'libelle' => $_POST['libelle'],
						'datedeb' => date("Y-m-d", strtotime(str_replace('/', '-',$_POST['datedeb']))),
						'datefin' => date("Y-m-d", strtotime(str_replace('/', '-',$_POST['datefin']))),
						'email' => $email,
						'tel' => $tel,
						'adminpublication' => $adminpublication
						));
					$req->closeCursor(); // Termine le traitement de la requête
					echo("<p>Ajout terminé</p>");
				}else if (isset($_POST['btmodifier']) AND isset($_POST['id'])) {
					$req = $bdd->prepare('UPDATE evenement SET titre=:titre, libelle=:libelle, datedeb=:datedeb, datefin=:datefin, email=:email, tel=:tel, adminpublication=:adminpublication WHERE id=:id');
					$req->execute(array(
						':titre' => $_POST['titre'],
						':libelle' => $_POST['libelle'],
						':datedeb' => date("Y-m-d", strtotime(str_replace('/', '-',$_POST['datedeb']))),
						':datefin' => date("Y-m-d", strtotime(str_replace('/', '-',$_POST['datefin']))),
						':email' => $email,
						':tel' => $tel,
						':adminpublication' => $adminpublication,
						':id' => intval($_POST['id'])
						));
					$req->closeCursor(); // Termine le traitement de la requête
					echo("<p>Modification terminée</p>");
				}else if (isset($_POST['btsupprimer']) AND isset($_POST['id'])) {
					$req = $bdd->prepare("DELETE FROM evenement WHERE id=:id");
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
	$libelle="";
	$datedeb="";
	$datefin="";
	$email="";
	$tel="";
	$adminpublication="";

	$titreErr="";
	$libelleErr="";
	$datedebErr="";
	$datefinErr="";
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$id=$_POST['id'];
		if (isset($_POST['titre'])){
			if (empty($_POST["titre"])) {
				$titreErr = "Titre obligatoire";
			}else{
				$titre=$_POST['titre'];
			}
		}
		if (isset($_POST['libelle'])){
			if (empty($_POST["libelle"])) {
				$libelleErr = "Libellé obligatoire";
			}else{
				$libelle=$_POST['libelle'];
			}
		}
		if (isset($_POST['datedeb'])){
			if (empty($_POST["datedeb"])) {
				$datedebErr = "Date de début obligatoire";
			}else{
				$datedeb=$_POST['datedeb'];
			}
		}
		if (isset($_POST['datefin'])){
			if (empty($_POST["datefin"])) {
				$datefinErr = "Date de fin obligatoire";
			}else{
				$datefin=$_POST['datefin'];
			}
		}
		$email=$_POST['email'];
		$tel=$_POST['tel'];
		$adminpublication=$_POST['adminpublication'];
	}
	/*Affichage des zones de saisies en modification et suppression*/
	if (isset($_GET['id'])){
		$reponseevenement = $bdd->prepare('SELECT * FROM evenement WHERE id=:id');
		$reponseevenement->execute(array('id' => $_GET['id']));
		while ($donneesevenement = $reponseevenement->fetch()){
			$id=$donneesevenement['id'];
			$titre=$donneesevenement['titre'];
			$libelle=$donneesevenement['libelle'];
			$datdeb = date_create($donneesevenement['datedeb']);
			$datedeb=date_format($datdeb, 'd/m/Y');
			$datfin = date_create($donneesevenement['datefin']);
			$datefin=date_format($datfin, 'd/m/Y');
			$email=$donneesevenement['email'];
			$tel=$donneesevenement['tel'];
			$adminpublication=$donneesevenement['adminpublication'];
		}
		$reponseevenement->closeCursor(); // Termine le traitement de la requête
	}
?>
			<p><label for="id">Id :</label><input type="number" name="id" id="id" value="<?php echo $id;?>" readonly></p>
			<p><label for="titre">Titre :</label><input type="text" name="titre" id="titre" size="50" value="<?php echo $titre;?>"><span class="error">* <?php echo $titreErr;?></span></p>
			<p><label for="libelle">Libellé :</label><textarea name="libelle" id="libelle" rows="10" cols="80">
			<?php echo $libelle;?>
			</textarea><span class="error">* <?php echo $libelleErr;?></span></p>
			<script>CKEDITOR.replace( 'libelle' );</script>
			<p><label for="datedeb">Date de début :</label><input type="date" name="datedeb" id="datedeb" maxlength="10" size="10" value="<?php echo $datedeb;?>"><span class="error">* <?php echo $datedebErr;?></span></p>
			<p><label for="datefin">Date de fin :</label><input type="date" name="datefin" id="datefin" maxlength="10" size="10" value="<?php echo $datefin;?>"><span class="error">* <?php echo $datefinErr;?></span></p>
			<p><label for="email">E-mail :</label><input type="email" name="email" id="email" size="30" value="<?php echo $email;?>"></p>
			<p><label for="tel">Téléphone :</label><input type="tel" name="tel" id="tel" maxlength="10" value="<?php echo $tel;?>"></p>
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