<!DOCTYPE html>
<?php include("config.php"); ?>
<?php include("login.php"); ?>
<?php $paramelem="page"; ?>
<html>
<?php include("head.php"); ?>
<?php include("loginsaisie.php"); ?>
<?php
	if (isset($_SESSION['login'])){
?>
		<?php include("nav.php"); ?>
<body>
		<?php include("evenement.php"); ?>
		<?php include("contenu.php"); ?>
		<?php include("carousel.php"); ?>
		<?php include("reservation.php"); ?>
</body>
		<?php
    }
?>
<?php include("foot.php"); ?>
</html>