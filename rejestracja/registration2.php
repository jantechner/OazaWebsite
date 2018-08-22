<?php 
	session_start();
	if (!isset($_SESSION['reginprogress'])) {
		header('Location: ../logowanie/log.php');
		exit();
	}

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		mysqli_report(MYSQLI_REPORT_STRICT);
		require_once "../connect.php";
		try {
			$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
			if ($polaczenie->connect_errno!=0) throw new Exception(mysqli_connect_errno());
			$polaczenie->set_charset("utf8");

			$flag = true;

			//pobranie danych z formularza
			$name = $_POST['name'];
			$secname = $_POST['secname'];
			$surname = $_POST['surname'];
			$pesel = $_POST['pesel'];
			$phone = $_POST['phone'];
			$street = $_POST['street'];
			$postcode = $_POST['postcode'];
			$city = $_POST['city'];
			$bday = $_POST['bday'];
			$bmonth = $_POST['bmonth'];
			$byear = $_POST['byear'];
			$nday = $_POST['nday'];
			$nmonth = $_POST['nmonth'];

			//WALIDACJA DANYCH
			//imie
			$name = trim($name);
			$check = strpos($name, ' ');
			while($check) {
				$name = substr($name, 0, $check).substr($name, $check+1);
				$check = strpos($name, ' ');
			}
			if(empty($name)) {
				$flag = false;
				$_SESSION['errname'] = "To pole nie może być puste!";
			} elseif (!preg_match('/^[\p{Latin}]+$/u', $name)) {
				$flag = false;
				$_SESSION['errname'] = "Imię może składać się tylko z liter!";
			}
			$name = mb_strtoupper(substr($name, 0, 1), 'UTF-8') . mb_strtolower(substr($name, 1), 'UTF-8');
			//drugie imie
			$secname = trim($secname);
			$check = strpos($secname, ' ');
			while($check) {
				$secname = substr($secname, 0, $check).substr($secname, $check+1);
				$check = strpos($secname, ' ');
			}	
			if (!empty($secname) && !preg_match('/^[\p{Latin}]+$/u', $secname)) {
				$flag = false;
				$_SESSION['errsecname'] = "Imię może składać się tylko z liter!";
			}
			$secname = mb_strtoupper(substr($secname, 0, 1), 'UTF-8') . mb_strtolower(substr($secname, 1), 'UTF-8');
			//nazwisko
			$surname = trim($surname);
			$surname = trim($surname, '-');
			$check = strpos($surname, ' ');
			while($check) {
				$surname = substr($surname, 0, $check).substr($surname, $check+1);
				$check = strpos($surname, ' ');
			}
			if(empty($surname)) {
				$flag = false;
				$_SESSION['errsurname'] = "To pole nie może być puste!";
			} elseif (!preg_match('/^[\p{Latin}-]+$/u', $surname)) {
				$flag = false;
				$_SESSION['errsurname'] = "Nazwisko może składać się tylko z liter i myślnika!";
			}
			$joinpos = strpos($surname, "-");
			if (!$joinpos) $surname = mb_strtoupper(substr($surname, 0, 1), 'UTF-8') . mb_strtolower(substr($surname, 1), 'UTF-8');
			else {
				$surname = mb_strtoupper(substr($surname, 0, 1), 'UTF-8') . mb_strtolower(substr($surname, 1, $joinpos-1), 'UTF-8').'-'.mb_strtoupper(substr($surname, $joinpos+1, 1), 'UTF-8') . mb_strtolower(substr($surname, $joinpos+2), 'UTF-8');
			}
			//pesel
			$pesel = trim($pesel);
			$check = strpos($pesel, ' ');
			while($check) {
				$pesel = substr($pesel, 0, $check).substr($pesel, $check+1);
				$check = strpos($pesel, ' ');
			}
			if(empty($pesel)) {
				// $flag = false;
				// $_SESSION['errpesel'] = "To pole nie może być puste!";
			} elseif (ctype_digit($pesel) == false) {
				$flag = false;
				$_SESSION['errpesel'] = "Pesel może składać się tylko z cyfr!";
			} elseif (strlen($pesel) != 11) {
				$flag = false;
				$_SESSION['errpesel'] = "Pesel musi składać się z 11 cyfr!";
			}
			//ulica
			$street = trim($street);
			if(empty($street)) {
				$flag = false;
				$_SESSION['errstreet'] = "To pole nie może być puste!";
			} elseif (!preg_match('/^[\p{Latin}0-9\/ .]+$/u', $street)) {
				$flag = false;
				$_SESSION['errstreet'] = "Ulica może składać się tylko z liter, cyfr i znaku '/'!";
			}
			//kod pocztowy
			$postcode = trim($postcode);
			$check = strpos($postcode, ' ');
			while($check) {
				$postcode = substr($postcode, 0, $check).substr($postcode, $check+1);
				$check = strpos($postcode, ' ');
			}
			if(empty($postcode)) {
				$flag = false;
				$_SESSION['errpostcode'] = "To pole nie może być puste!";
			} elseif (!preg_match('/^[0-9-]+$/u', $postcode)) {
				$flag = false;
				$_SESSION['errpostcode'] = "Kod pocztowy może składać się tylko z cyfr i myślnika!";
			} elseif (strlen($postcode) != 6) {
				$flag = false;
				$_SESSION['errpostcode'] = "Kod pocztowy musi składać się z pięciu cyfr i myślnika!";
			} elseif (strpos($postcode, '-') != 2 ) {
				$flag = false;
				$_SESSION['errpostcode'] = "Błędny kod pocztowy!";
			} elseif (strpos($postcode, '-', 3) != false) {
				$flag = false;
				$_SESSION['errpostcode'] = "Błędny kod pocztowy!";
			}
			//miasto
			$city = trim($city);
			$city = trim($city, '-');
			if(empty($city)) {
				$flag = false;
				$_SESSION['errcity'] = "To pole nie może być puste!";
			} elseif (!preg_match('/^[\p{Latin} -]+$/u', $city)) {
				$flag = false;
				$_SESSION['errcity'] = "Nazwa miasta może składać się tylko z liter, myślnika i spacji!";
			}
			//telefon
			$phone = trim($phone);
			$check = strpos($phone, ' ');
			while($check) {
				$phone = substr($phone, 0, $check).substr($phone, $check+1);
				$check = strpos($phone, ' ');
			}
			$check = strpos($phone, '-');
			while($check) {
				$phone = substr($phone, 0, $check).substr($phone, $check+1);
				$check = strpos($phone, '-');
			}
			if(empty($phone)) {
				$flag = false;
				$_SESSION['errphone'] = "To pole nie może być puste!";
			} elseif (ctype_digit($phone) == false) {
				$flag = false;
				$_SESSION['errphone'] = "Numer telefonu może składać się tylko z cyfr!";
			} elseif (strlen($phone) != 9) {
				$flag = false;
				$_SESSION['errphone'] = "Numer telefonu musi składać się z 9 cyfr!";
			}
			//data urodzenia
			if ($byear == 2018) {
				$flag = false;
				$_SESSION['errbday'] = "Nie podano daty urodzenia!";
			}
			//data imienin
			if ($nday == 1 && $nmonth == 1 && $name != 'Mieczysław') {
				$flag = false;
				$_SESSION['errnday'] = "Nie podano daty imienin!";
			}

			//Zapamiętaj wprowadzone dane
			$_SESSION['remname'] = $name;
			$_SESSION['remsecname'] = $secname;
			$_SESSION['remsurname'] = $surname;
			$_SESSION['rempesel'] = $pesel;
			$_SESSION['remphone'] = $phone;
			$_SESSION['remstreet'] = $street;
			$_SESSION['rempostcode'] = $postcode;
			$_SESSION['remcity'] = $city;
			$_SESSION['rembday'] = $bday;
			$_SESSION['rembmonth'] = $bmonth;
			$_SESSION['rembyear'] = $byear;
			$_SESSION['remnday'] = $nday;
			$_SESSION['remnmonth'] = $nmonth;

			if ($flag == true) {
				$newid = $_SESSION['idsharer'];
				$sql = "UPDATE sharers_personal SET name='$name'";
				$sql .= ", second_name='$secname'";
				$sql .= ", surname='$surname'";
				$sql .= ", pesel='$pesel'";
				$sql .= ", phone_number='$phone'";
				$sql .= ", address_street='$street'";
				$sql .= ", address_postcode='$postcode'";
				$sql .= ", address_city='$city'";
				$sql .= ", birth_day='$bday'";
				$sql .= ", birth_month='$bmonth'";
				$sql .= ", birth_year='$byear'";
				$sql .= ", nameday_day='$nday'";
				$sql .= ", nameday_month='$nmonth'";
				$sql .= " WHERE id_sharer = $newid";

				$polaczenie->query($sql);
				if ($polaczenie->errno!=0) throw new Exception($polaczenie->error);
				header('Location: registration3.php');
			}
			$polaczenie->close();
		} catch(Exception $e) {
			echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności!"</span>';
			echo '<br /> Informacja developerska: '.$e; // do usunięcia
		}
	}
	$miesiac = array('', 'stycznia', 'lutego', 'marca', 'kwietnia', 'maja', 'czerwca', 'lipca', 'sierpnia', 'września', 'października', 'listopada', 'grudnia');
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
				$('#progress').css('width', '40%');
			});
		});
	</script>
</head>
<body>
	<div id="reg">REJESTRACJA</div>
	<div id="frameprogress">
		<div id="progress" style="width: 20%;" ></div>
	</div>
	<div id="main">
		<span class="inputheader">Dane personalne</span>
		<form method="post">
			<?php
				$fields = array(
					array("Imię", "name", "remname", "errname"), 
					array("Drugie imię", "secname", "remsecname", "errsecname"), 
					array("Nazwisko", "surname", "remsurname", "errsurname"), 
					array("Ulica", "street", "remstreet", "errstreet"), 
					array("Kod pocztowy", "postcode", "rempostcode", "errpostcode"), 
					array("Miasto", "city", "remcity", "errcity"),
					array("Pesel", "pesel", "rempesel", "errpesel"),
					array("Numer telefonu", "phone", "remphone", "errphone")
				); 

				for ($i = 0; $i <= 5; $i++) {
				    echo '<span class="lheader">'.$fields[$i][0].'</span><input id="'.$fields[$i][1].'" type="text" ';
				    if (isset($_SESSION[$fields[$i][2]])) echo 'value="'.$_SESSION[$fields[$i][2]].'" ';
				    echo 'name="'.$fields[$i][1].'"/> <br/>';
				    if (isset($_SESSION[$fields[$i][3]])) {
				    	echo '<div class="error">'.$_SESSION[$fields[$i][3]].'</div>'; 
				    	unset($_SESSION[$fields[$i][3]]); 
				    }
				}
			?>
			
			<span class="lheader">Data urodzenia</span>

			<select name="bday" id="bday">
			 	<?php 
			 		for($i=1; $i<32; $i++) { 
			 			if ( $_SESSION['rembday'] == "$i" ) echo "<option selected>".$i."</option>"; 
			 			else echo "<option>".$i."</option>"; } ?>
			</select>

			<select name="bmonth" id="bmonth">
			 	<?php 
			 		for($i=1; $i<13; $i++) { 
			 			if( $_SESSION['rembmonth'] == "$i" ) echo "<option value='".$i."' selected>".$miesiac[$i]."</option>"; 
			 			else echo "<option  value='".$i."'>".$miesiac[$i]."</option>"; } ?>
			</select>
			<select name="byear" id="byear">
			 	<?php 
			 		//echo '<option style="font-family: "Ubuntu", sans-serif;">Dzień</option>';
			 		for($i=date("Y"); $i>=1980; $i--) { 
			 			if( $_SESSION['rembyear'] == "$i" ) echo "<option selected>".$i."</option>"; 
			 			else echo "<option>".$i."</option>"; } ?>
			</select>

			<br/>
				<?php 
					if(isset($_SESSION['errbday'])) { 
						echo '<div class="error">' . $_SESSION['errbday'] . "</div>";
						unset($_SESSION['errbday']); 
					} 
				?>

			<span class="lheader">Data imienin</span>
			<select name="nday" id="nday">
			 	<?php 
			 		for($i=1; $i<32; $i++) { 
			 			if( $_SESSION['remnday'] == "$i" ) echo "<option selected>".$i."</option>"; 
			 			else echo "<option>".$i."</option>"; } ?>
			</select>
			<select name="nmonth" id="nmonth">
			 	<?php 
			 		for($i=1; $i<13; $i++) { 
			 			if( $_SESSION['remnmonth'] == "$i" ) echo "<option value='".$i."' selected>".$miesiac[$i]."</option>"; 
			 			else echo "<option  value='".$i."'>".$miesiac[$i]."</option>"; } ?>
			</select>

			<br/>
				<?php 
					if(isset($_SESSION['errnday'])) { 
						echo '<div class="error">' . $_SESSION['errnday'] . "</div>";
						unset($_SESSION['errnday']); 
					} 
				?>
			<?php 
				for ($i = 6; $i <= 7; $i++) {
				    echo '<span class="lheader">'.$fields[$i][0].'</span><input id="'.$fields[$i][1].'" type="text" ';
				    if (isset($_SESSION[$fields[$i][2]])) echo 'value="'.$_SESSION[$fields[$i][2]].'" ';
				    echo 'name="'.$fields[$i][1].'"/> <br/>';
				    if (isset($_SESSION[$fields[$i][3]])) {
				    	echo '<div class="error">'.$_SESSION[$fields[$i][3]].'</div>'; 
				    	unset($_SESSION[$fields[$i][3]]); 
				    }
				}
			 ?>
			<input type="submit" value="Nastepny krok">
		</form>
	</div>
</body>
</html> 