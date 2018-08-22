<?php 
	session_start();
	if ( !isset($_SESSION['zalogowany'])) {
		header('Location: ../logowanie/log.php');
		exit();
	}
 ?>
<!DOCTYPE html>
<html lang="pl-PL">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="Ie=edge, chrome =1" />
	<link rel="stylesheet" type="text/css" href="style.css">
	<link href="https://fonts.googleapis.com/css?family=Ubuntu:400,500,700&amp;subset=latin-ext" rel="stylesheet">
	<title>Osadnicy - gra przeglądarkowa</title>
</head>
<body>

		<div id="unav">
			<a href="uczestnik.php"> <div class="navblock"> Uczestnik </div> </a>
			<div class="navblock"> <?php echo "Witaj " . $_SESSION['name'] . '!' ?> </div>
			<a href="../logowanie/logout.php"> <div class="navblock" style=" float: right; ">Wyloguj się!</div></a>
			<div style="clear:both;"></div>
		</div> 
		<div id="menu">
			<div class="submenu">
				<a href="#"> <div class="choice">Przegląd</div> </a>
				<a href="uczestnik_mojedane.php"> <div class="choice">Moje dane</div> </a>
				<a href="#"> <div class="choice">Moje rekolekcje</div> </a>
			</div>
			<div class="submenu">
				<a href="#"> <div class="choice">Kontakt</div> </a>
			</div>
			<div class="submenu">
				<a href="#"> <div class="choice">Zmień hasło</div> </a>
				<a href="../logowanie/logout.php"> <div class="choice">Wyloguj się</div> </a>

			</div>
		</div>
		<div id="con">
			<div id="con1">
				Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
				tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
				quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
				consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
				cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
				proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
			</div>
		</div>
	
	
</body>
</html>