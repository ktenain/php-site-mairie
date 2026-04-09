    <head>
		<?php if ($paramelem=="admin"){ ?>
			<title>Edition du site</title>
		<?php }else{ ?>
			<title>Site</title>
		<?php } ?>
        <meta charset="utf-8">
		<!--[if lte IE 7]>
			<link rel="stylesheet" href="style_ie.css" />
        	<![endif]-->
		<!--[if lt IE 9]>
		        <script src="http://github.com/aFarkas/html5shiv/blob/master/dist/html5shiv.js"></script>
        	<![endif]-->
<?php if ($paramelem=="admin"){ ?>
		<script src="ckeditor/ckeditor.js"></script>
		<link rel="stylesheet" href="/jquery/jquery-ui.css">
		<script src="jquery/jquery-ui.js"></script>
<?php } ?>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="bootstrap/bootstrap.min.css">
		<script src="bootstrap/jquery.min.js"></script>
		<script src="bootstrap/bootstrap.min.js"></script>
		<link rel="stylesheet" href="css/style.css">
		<link rel="stylesheet" href="css/carousel.css">
		<?php if ($parampage=="reservation"){ ?>
		<script src="js/reservation.js"></script>
		<?php } ?>
		<header>
		<?php if ($paramelem=="page"){ ?>
			<?php if (isset($_SESSION['login'])){?>
				<a href="admin.php">
			<?php } ?>
			<img src="images/logo.png" alt="Logo" title="Logo" width="10%">
			<?php if (isset($_SESSION['login'])){?>
				</a>
			<?php } ?>
		<?php } ?>
		<?php if ($paramelem=="admin"){ ?>
		<a href="index.php">
		<img src="images/logo.png" alt="Logo" title="Logo" width="10%">
		</a>
		<?php } ?>
		</header>
    </head>