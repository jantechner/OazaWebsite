<?php 
	session_start();
	if ((isset($_SESSION['zalogowany'])) && ($_SESSION['zalogowany'] == true)) {
		header('Location: ../uczestnik/uczestnik.php');
		exit();
	}
?>

<!DOCTYPE html>
<html lang="pl-PL">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="Ie=edge, chrome =1" />
	<title>DOR - logowanie</title>
</head>
<body>
	<a href="../rejestracja/registration1.php">Rejestracja - załóż konto!</a> <br /> <br />
	<form action="logcheck.php" method="post">
		Login: <br/>
		<input type="text" name="login" value="<?php if (isset($_SESSION['remlogemail'])) echo $_SESSION['remlogemail']; ?>" /> <br/>
		Hasło: <br/>
		<input type="password" name="haslo" value="<?php if (isset($_SESSION['remlogpassword'])) echo $_SESSION['remlogpassword']; ?>"/> <br/> <br/>
		<input type="submit" value="Zaloguj się">
	</form>
<?php 
	if (isset($_SESSION['blad'])) {
		echo $_SESSION['blad'];
	}
 ?>
</body>
</html>