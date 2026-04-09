<?php
	if (((isset($_POST['password'])) AND (isset($_POST['login'])) AND (!isset($_SESSION['login'])))){
		$reponselogin = $bdd->prepare('SELECT * FROM utilisateur WHERE login=:login');
		$reponselogin->execute(array('login' => $_POST['login']));
		while ($donneeslogin = $reponselogin->fetch()){
			if ($donneeslogin['password']==$_POST['password']){
				$_SESSION['login'] = $_POST['login'] ;
				$_SESSION['admingroupe'] = $donneeslogin['admingroupe'] ;
				$_SESSION['adminreservation'] = $donneeslogin['adminreservation'] ;
				$_SESSION['adminevenement'] = $donneeslogin['adminevenement'] ;
				$_SESSION['admincontenu'] = $donneeslogin['admincontenu'] ;
				$_SESSION['adminpublication'] = $donneeslogin['adminpublication'] ;
			}
		}
		$reponselogin->closeCursor(); // Termine le traitement de la requête
	}
?>