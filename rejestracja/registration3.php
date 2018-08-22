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
			$aclass = $_POST['aclass'];
			$stype = $_POST['stype'];
			$school = $_POST['school'];
			$parish = $_POST['parish'];
			$diocese = $_POST['diocese'];
			$oparish = $_POST['oparish'];

			//WALIDACJA DANYCH
			//klasa
			if ($stype == 'L') {
				if( $aclass > 3 ) {
					$flag = false;
					$_SESSION['errclass'] = "W liceum są tylko 3 klasy!";
				}
			}
			if ($stype == 'G') {
				if( $aclass > 3 ) {
					$flag = false;
					$_SESSION['errclass'] = "W gimnazujm są tylko 3 klasy!";
				}
			}
			//szkoła
			$school = trim($school);
			if(empty($school)) {
				$flag = false;
				$_SESSION['errschool'] = "To pole nie może być puste!";
			} elseif (!preg_match('/^[\p{Latin}0-9 .]+$/u', $school)) {
				$flag = false;
				$_SESSION['errschool'] = "Nazwa szkoły może składać się tylko z liter i cyfr!";
			}
			//parafia
			$parish = trim($parish);
			if(empty($parish)) {
				$flag = false;
				$_SESSION['errparish'] = "To pole nie może być puste!";
			} elseif (!preg_match('/^[\p{Latin} .]+$/u', $parish)) {
				$flag = false;
				$_SESSION['errparish'] = "Nazwa parafii może składać się z samych liter!";
			}
			//diecezja
			$diocese = trim($diocese);
			$diocese = trim($diocese, '-');
			$check = strpos($diocese, ' ');
			while($check) {
				$diocese = substr($diocese, 0, $check).substr($diocese, $check+1);
				$check = strpos($diocese, ' ');
			}
			if(empty($diocese)) {
				$flag = false;
				$_SESSION['errdiocese'] = "To pole nie może być puste!";
			} elseif (!preg_match('/^[\p{Latin}-]+$/u', $diocese)) {
				$flag = false;
				$_SESSION['errdiocese'] = "Nazwa diecezji może składać się z samych liter!";
			}
			//oaza w parafii
			$oparish = trim($oparish);
			if(empty($oparish)) {
				$flag = false;
				$_SESSION['erroparish'] = "To pole nie może być puste!";
			} elseif (!preg_match('/^[\p{Latin} .]+$/u', $oparish)) {
				$flag = false;
				$_SESSION['erroparish'] = "Nazwa parafii może składać się z samych liter!";
			}

			//Zapamiętaj wprowadzone dane
			$_SESSION['remaclass'] = $aclass;
			$_SESSION['remstype'] = $stype;
			$_SESSION['remschool'] = $school;
			$_SESSION['remparish'] = $parish;
			$_SESSION['remdiocese'] = $diocese;
			$_SESSION['remoparish'] = $oparish;

			if ($flag == true) {
				$newid = $_SESSION['idsharer'];
				$sql = "UPDATE sharers_school SET after_class='$aclass'";
				$sql .= ", school_type='$stype'";
				$sql .= ", school='$school'";
				$sql .= ", parish='$parish'";
				$sql .= ", diocese='$diocese'";
				$sql .= ", oaza_parish='$oparish'";
				$sql .= " WHERE id_sharer = $newid";
				$polaczenie->query($sql);
				if ($polaczenie->errno!=0) throw new Exception($polaczenie->error);
				header('Location: registration4.php');
			}
			$polaczenie->close();
		} catch(Exception $e) {
			echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności!"</span>';
			echo '<br /> Informacja developerska: '.$e;  // do usunięcia
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
				$('#progress').css('width', '60%');
			});
		});
	</script>
</head>
<body>
	<div id="reg">REJESTRACJA</div>
	<div id="frameprogress">
		<div id="progress" style="width: 40%;" ></div>
	</div>
	<div id="main">
		<span class="inputheader">Edukacja</span>
		<form method="post">
			<span class="lheader" style="display: inline;">W najbliższe wakacje będziesz po </span>
			<select name="aclass" id="aclass" >
			 	<?php 
			 		for ($i=1; $i<=8; $i++) {
			 			if( $_SESSION['remaclass'] == "$i" ) echo "<option selected>".$i."</option>"; 
			 			else echo "<option>".$i."</option>"; } ?>
			</select>
			<span class="lheader" style="display: inline;">klasie</span>

			<select name="stype" id="stype">
			 	<?php 
		 			if( $_SESSION['remstype'] == 'P' ) {
		 				echo "<option value='P' selected>szkoły podstawowej</option>"; 
		 			} else echo "<option value='P'>szkoły podstawowej</option>"; 

		 			if ( $_SESSION['remstype'] == 'G' ) {
		 				echo "<option value='G' selected>gimnazjum</option>"; 
		 			} else echo "<option value='G'>gimnazjum</option>"; 

		 			if ( $_SESSION['remstype'] == 'L' ) {
		 				echo "<option value='L' selected>liceum</option>"; 
		 			} else echo "<option value='L'>liceum</option>"; 
		 		?>
			</select>
			<br/>
				<?php 
					if(isset($_SESSION['errclass'])) { 
						echo '<div class="error">' . $_SESSION['errclass'] . "</div>";
						unset($_SESSION['errclass']); } ?>

			<?php
				$fields = array(
					array("Nazwa szkoły", "school", "remschool", "errschool"), 
					array("Parafia", "parish", "remparish", "errparish"), 
					array("Diecezja", "diocese", "remdiocese", "errdiocese"), 
					array("Oaza w parafii", "oparish", "remoparish", "erroparish")
				); 

				for($i=0; $i<=3; $i++) {
				    echo '<span class="lheader">'.$fields[$i][0].'</span><input id="'.$fields[$i][1].'" type="text" ';
				    if (isset($_SESSION[$fields[$i][2]])) echo 'value="'.$_SESSION[$fields[$i][2]].'" ';
				    echo 'name="'.$fields[$i][1].'"/> <br/>';
				    if (isset($_SESSION[$fields[$i][3]])) {
				    	echo '<div class="error">'.$_SESSION[$fields[$i][3]].'</div>'; 
				    	unset($_SESSION[$fields[$i][3]]); 
					}
					if ($i == 0) echo '<span class="inputheader" style="margin-top: 20px;">Parafia i wspólnota</span>';
				}
			?>
		
			<input type="submit" value="Nastepny krok">
		</form>
	</div>
</body>
</html> 