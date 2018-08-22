<?php 
	session_start();
	if ( !isset($_SESSION['zalogowany'])) {
		header('Location: log_index.php');
		exit();
	}
?>
<!DOCTYPE html>
<html lang="pl-PL">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="Ie=edge, chrome =1" />
	<title>Osadnicy - gra przeglądarkowa</title>
</head>
<body>

	<?php
		echo "<h1> Animator </h1> </br>";
		echo "<p> Witaj " . $_SESSION['email'] . '! <a href="../logowanie/logout.php">Wyloguj się!</a></p>';
		echo "<p> <b>Hasło</b>: " . $_SESSION['password'];
		echo " | <b>ID</b>: " . $_SESSION['id_animator'] . "</p> <br /> <br/ >";
		echo " Name : " . $_SESSION['name'] . "<br/>";
		echo " Second name : " . utf8_decode($_SESSION['second_name']) . "<br/>";
		echo " Surname : " . $_SESSION['surname'] . "<br/>";
		echo " Pesel : " . $_SESSION['pesel'] . "<br/>";
		echo " Phone number : " . $_SESSION['phone_number'] . "<br/>";
		echo " Ulica : " . $_SESSION['address_street'] . "<br/>";
		echo " Kod pocztowy : " . $_SESSION['address_postcode'] . "<br/>";
		echo " Miasto : " . $_SESSION['address_city'] . "<br/>";
		echo " Dzień : " . $_SESSION['birth_day'] . "<br/>";
		echo " Miesiąc : " . $_SESSION['birth_month'] . "<br/>";
		echo " Rok : " . $_SESSION['birth_year'] . "<br/>";
		echo " Imieniny  : " . $_SESSION['nameday_day'] . "<br/>";
		echo " Imieniny : " . $_SESSION['nameday_month'] . "<br/>";
	?>
	
</body>
</html>