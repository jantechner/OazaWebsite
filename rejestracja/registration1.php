<?php 
	session_start();

	if(isset($_SESSION['erremail'])) unset($_SESSION['erremail']);
	if(isset($_SESSION['errhaslo'])) unset($_SESSION['errhaslo']);
	if(isset($_SESSION['errbot'])) unset($_SESSION['errbot']); 

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		mysqli_report(MYSQLI_REPORT_STRICT);
		require_once "../connect.php";
		try {
			$polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
			if ($polaczenie->connect_errno!=0) throw new Exception(mysqli_connect_errno());
			$polaczenie->set_charset("utf8");

			//pobranie danych z pól formularza
			$email = $_POST['email'];
			$haslo1 = $_POST['haslo1'];
			$haslo2 = $_POST['haslo2'];
			$sekret = "6Le5PDAUAAAAAIsEPIb_8fzy662wE_hD5x0iTvQg";
			$sprawdz = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$sekret.'&response='.$_POST['g-recaptcha-response']);
			$odpowiedz = json_decode($sprawdz);

			$flag = true;  // poprawna dopóki wszystkie dane są poprawne 

			//walidacja danych
			$email_b = filter_var($email, FILTER_SANITIZE_EMAIL);
			if ((filter_var($email_b, FILTER_VALIDATE_EMAIL) == false) || ($email_b != $email)) {
				$flag = false;
				$_SESSION['erremail'] = "Podano niepoprawny adres email!";
			}

			$result = @$polaczenie->query("SELECT 1 FROM sharers_log WHERE email='$email'");
			if(!$result) throw new Exception($polaczenie->error);
			if(($result->num_rows == 1) && (!isset($_SESSION['reginprogress']))) {
				$flag = false;
				$_SESSION['erremail'] = "Istnieje już konto przypisane do tego adresu email!";
			}

			if ($haslo1 != $haslo2) {
				$flag = false;
				$_SESSION['errhaslo'] = "Podane hasła nie są identyczne!";
			}

			if ((strlen($haslo1) < 8) || (strlen($haslo1) > 20)) {
				$flag = false;
				$_SESSION['errhaslo'] = "Hasło musi posiadać od 8 do 20 znaków!";
			}

			if ($odpowiedz->success == false) {
				$flag = false;
				$_SESSION['errbot'] = "Potwierdź, że nie jesteś robotem!";
			}

			//$haslo_hash = password_hash($haslo1, PASSWORD_DEFAULT);

			//Zapamiętanie danych formularza
			$_SESSION['rememail'] = $email;
			$_SESSION['remhaslo1'] = $haslo1;
			$_SESSION['remhaslo2'] = $haslo2;
			
			if ($flag == true) {
				if (!isset($_SESSION['reginprogress'])) { 
					$polaczenie->query("INSERT INTO sharers_personal (email) VALUES ('$email')");
					if ($polaczenie->errno!=0) throw new Exception($polaczenie->error);
					$newid = $polaczenie->insert_id;
					$_SESSION['idsharer'] = $newid;
					$polaczenie->query("INSERT INTO sharers_log VALUES ('$newid', '$email', '$haslo1')");
					$polaczenie->query("INSERT INTO sharers_school (id_sharer) VALUES ('$newid')");
					$polaczenie->query("INSERT INTO sharers_formation (id_sharer) VALUES ('$newid')");

					$_SESSION['reginprogress']=true;
				} else {
					$ID = $_SESSION['idsharer'];
					$polaczenie->query("UPDATE sharers_log SET email='$email', password='$haslo1' WHERE id_sharer = $ID");
					if ($polaczenie->errno!=0) throw new Exception($polaczenie->error);
					$polaczenie->query("UPDATE sharers_personal SET email='$email' WHERE id_sharer = $ID");
				}
				header('Location: registration2.php');
			}
			$polaczenie->close();
		} catch(Exception $e) {
			echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności!"</span>';
			echo '<br /> Informacja developerska: '.$e;  // do usunięcia
		}
	}

function printError($var) {
	echo '<div class="error">' . $var . "</div>";
}
?>
<!DOCTYPE html>
<html lang="pl-PL">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge, chrome =1" />
	<title>DOR - Rejestracja</title>
	<script src='https://www.google.com/recaptcha/api.js'></script>
	<link href="https://fonts.googleapis.com/css?family=Ubuntu:400,500,700&amp;subset=latin-ext" rel="stylesheet" />
	<link rel="stylesheet" type="text/css" href="style.css" />
	<script src="https://code.jquery.com/jquery-3.2.1.js"
  		    integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE="
  		    crossorigin="anonymous"></script>
	<script>
		$(document).ready(function() {
			$('body').fadeIn(100, function(){
				$('#progress').css('width', '20%');
			});
		});
	</script>
</head>
<body>
	<div id="reg">REJESTRACJA</div>
	<div id="frameprogress">
		<div id="progress"></div>
	</div>
	<div id="main">
		<span class="inputheader">Dane podstawowe</span>
		<form method="post">
			<span class="lheader">Email</span><input id="email" type="text" value="<?php 
				if (isset($_SESSION['rememail'])) echo $_SESSION['rememail']; ?>" name="email"/> <br/>
				<?php if(isset($_SESSION['erremail'])) printError($_SESSION['erremail']); ?>

			<span class="lheader">Hasło</span><input type="password" value="<?php 
				if (isset($_SESSION['remhaslo1'])) echo $_SESSION['remhaslo1']; ?>" name="haslo1"/><br/>
				<?php if (isset($_SESSION['errhaslo'])) printError($_SESSION['errhaslo']); ?>

			<span class="lheader">Powtórz hasło</span><input type="password" value="<?php
				if (isset($_SESSION['remhaslo2'])) echo $_SESSION['remhaslo2']; ?>" name="haslo2"/><br/>

			<div class="g-recaptcha" data-sitekey="6Le5PDAUAAAAADcSN7o64LU3LWdJ-BTil-ScHJoj"></div>
				<?php if (isset($_SESSION['errbot'])) printError($_SESSION['errbot']); ?><br/>

			<input type="submit" value="<?php 
				if (isset($_SESSION['reginprogress'])) echo 'Następny krok';
				else echo 'Zarejestruj się'; ?>" />

		</form>
	</div>
</body>
</html> 