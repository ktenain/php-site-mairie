<?php
session_start();
/*Connection base de donnée*/
try{
	$bdd = new PDO('mysql:host=localhost;dbname=lorem;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}catch (Exception $e){
		die('Erreur : ' . $e->getMessage());
}
//Page par défaut
if (!isset($_GET['page'])){
	$parampage="accueil";
}else{
	$parampage=$_GET['page'];
}
//Type de contenu par défaut
if (!isset($_GET['type'])){
	$paramtype="contenu";
}else{
	$paramtype=$_GET['type'];
}
//Langue par défaut
if (!isset($_GET['langue'])){
	$paramlangue="Fr";
}else{
	$paramlangue=$_GET['langue'];
}
//Ressource par défaut
$ressource = array();
if (!isset($_GET['ressource'])){
	$ressource="1";
}else{
	$resource=$_GET['ressource'];
}
//Type d'affichage par défaut
//On n'est logué
if (!isset($_SESSION['adminpublication'])){
	$parammode="public";
}else{
	//On n'est pas admingroupe
	if ($_SESSION['admingroupe']!=="*"){
		$parammode="public";
	}else{
		//Pas de mode
		if (!isset($_GET['mode'])){
			$parammode="public";
		}else{
			$parammode=$_GET['mode'];
		}
	}
}
?>