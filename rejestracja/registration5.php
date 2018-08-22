<?php 
	session_start();
	if (!isset($_SESSION['reginprogress'])) {
		header('Location: ../logowanie/log.php');
		exit();
	}

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		require_once "clearSessionAfterRegistration.php";
		header('Location: ../logowanie/log.php');
		// mysqli_report(MYSQLI_REPORT_STRICT);
		// require_once "../connect.php";
		// try {
		// 	$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
		// 	$polaczenie->set_charset("utf8");

		// 	if ($polaczenie->connect_errno!=0) {
		// 		throw new Exception(mysqli_connect_errno());
		// 	} else {

		// 		$flag = true;
		// 		$email = $_POST['email'];

		// 		$email_b = filter_var($email, FILTER_SANITIZE_EMAIL);
		// 		if ((filter_var($email_b, FILTER_VALIDATE_EMAIL) == false) || ($email_b != $email)) {
		// 			$flag = false;
		// 			$_SESSION['erremail'] = "Podano niepoprawny adres email!";
		// 		}

		// 		$haslo1 = $_POST['haslo1'];
		// 		$haslo2 = $_POST['haslo2'];

		// 		if ((strlen($haslo1) < 8) || (strlen($haslo1) > 20)) {
		// 			$flag = false;
		// 			$_SESSION['errhaslo'] = "Hasło musi posiadać od 8 do 20 znaków!";
		// 		}
		// 		if ($haslo1 != $haslo2) {
		// 			$flag = false;
		// 			$_SESSION['errhaslo'] = "Podane hasła nie są identyczne!";
		// 		}
		// 		//Hashowanie hasła
		// 		//$haslo_hash = password_hash($haslo1, PASSWORD_DEFAULT);

		// 		//Sprawdź checkbox captcha
		// 		$sekret = "6Le5PDAUAAAAAIsEPIb_8fzy662wE_hD5x0iTvQg";
		// 		$sprawdz = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$sekret.'&response='.$_POST['g-recaptcha-response']);
		// 		$odpowiedz = json_decode($sprawdz);
		// 		if ($odpowiedz->success == false) {
		// 			$flag = false;
		// 			$_SESSION['errbot'] = "Potwierdź, że nie jesteś robotem!";
		// 		}

		// 		//Zapamiętaj wprowadzone dane
		// 		$_SESSION['rememail'] = $email;
		// 		$_SESSION['remhaslo1'] = $haslo1;
		// 		$_SESSION['remhaslo2'] = $haslo2;

		// 		//Czy email już istnieje?
		// 		$result = $polaczenie->query("SELECT id_sharer FROM sharers_log WHERE email='$email'");
		// 		if(!$result) throw new Exception($polaczenie->error);

		// 		$ile = $result->num_rows;
		// 		if(($ile > 0) && (!isset($_SESSION[reginprogress]))) {
		// 			$flag = false;
		// 			$_SESSION['erremail'] = "Istnieje już konto przypisane do tego adresu email!";
		// 		}


				
		// 		if ($flag == true) {

		// 			if(!isset($_SESSION['reginprogress'])) { 
		// 				if ( $polaczenie->query("INSERT INTO sharers_personal (email) VALUES ('$email')")) {
		// 					$newid = $polaczenie->insert_id;
		// 					$_SESSION['idsharer'] = $newid;
		// 					$polaczenie->query("INSERT INTO sharers_log VALUES ('$newid', '$email', '$haslo1')");
		// 					$polaczenie->query("INSERT INTO sharers_school (id_sharer) VALUES ('$newid')");
		// 					$polaczenie->query("INSERT INTO sharers_formation (id_sharer) VALUES ('$newid')");

		// 					$_SESSION['reginprogress']=true;
		// 					header('Location: registration2.php');

		// 				} else {
		// 					throw new Exception($polaczenie->error);
		// 				} 
		// 			} else {
		// 				$newid = $_SESSION['idsharer'];
		// 				if ( $polaczenie->query("UPDATE sharers_log SET email='$email', password='$haslo1' WHERE id_sharer = $newid ")) {
		// 					$polaczenie->query("UPDATE sharers_personal SET email='$email' WHERE id_sharer = $newid ");
		// 					header('Location: registration2.php');
		// 				} else {
		// 					throw new Exception($polaczenie->error);
		// 				} 
		// 			}
		// 		}
		// 		$polaczenie->close();
		// 	}
		// } catch(Exception $e) {
		// 	echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności!"</span>';
		// 	echo '<br /> Informacja developerska: '.$e;
		// }
	}
?>
<!DOCTYPE html>
<html lang="pl-PL">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge, chrome =1" />
	<title>DOR - Rejestracja</title>
	<link href="https://fonts.googleapis.com/css?family=Ubuntu:400,500,700&amp;subset=latin-ext" rel="stylesheet" />
	<link rel="stylesheet" type="text/css" href="style.css" />
	<script src="https://code.jquery.com/jquery-3.2.1.js"
  		    integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE="
  		    crossorigin="anonymous"></script>
	<script>
		$(document).ready(function() {
			$('body').fadeIn(100, function() {
				$('#progress').css('width', '100%');
			});
		});
	</script>
</head>
<body>
	<div id="reg">REJESTRACJA</div>
	<div id="frameprogress">
		<div id="progress" style="width: 80%;" ></div>
	</div>
	<div id="main">
		<span class="inputheader">Rejestracja została ukończona!</span>
		<span class="lheader">TODO Proponowane rekolekcje</span>
		<form method="post">
			<input type="submit" value="Powrót do strony logowania"/>
		</form>
	</div>
</body>
</html> 