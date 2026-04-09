<?php
	if (!isset($_SESSION['login'])){
		if ((isset($_POST['password'])) OR (isset($_POST['login']))){
?>
			<p>Mot de passe incorrecte</p>
<?php
		} 
?>
			<p>Veuillez entrer votre login et mot de passe</p>
			<form action="page.php" method="post">
				<p><label for="login">Login :</label><input type="text" name="login" id="login" required></p>
				<p><label for="password">Mot de passe :</label><input type="password" name="password" id="password" required></p>
				<p><button type="submit">Valider</button></p>
			</form>
<?php
}
?>