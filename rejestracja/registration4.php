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

			$pole = array(	array('ond1', 'ond1y', 'remond1', 'remond1y', 'errond1', "R"),
							array('ond2', 'ond2y', 'remond2', 'remond2y', 'errond2', "R"),
							array('ond3', 'ond3y', 'remond3', 'remond3y', 'errond3', "R"),
							array('onz1', 'onz1y', 'remonz1', 'remonz1y', 'erronz1', "R"),
							array('onz1bis', 'onz1bisy', 'remonz1bis', 'remonz1bisy', 'erronz1bis', "R"),
							array('deuter', 'deutery', 'remdeuter', 'remdeutery', 'errdeuter', "R"),
							array('kkdc', 'kkdcamt', 'remkkdc', 'remkkdcamt', 'errkkdc', "I"),
							array('dw', 'dwamt', 'remdw', 'remdwamt', 'errdw', "I"),
							array('om', 'omamt', 'remom', 'remomamt', 'errom', "I"),
							array('kwc_cz', 'kwc_czy', 'remkwc_cz', 'remkwc_czy', 'errkwc', "R"),
							array('odb1', 'remodb1'),
							array('odb2', 'remodb2'),
							array('odb3', 'remodb3'),
							array('rek_ew', 'remrek_ew'),
							array('lk4', 'remlk4'),
							array('j8', 'remj8'),
							array('erz', 'remerz'),
							array('dnz', 'remdnz'),
							array('kwc_k', 'remkwc_k'),
							array('kwc_not', 'remkwc_not')
						);
			$result = array(array(0, 0), array(0, 0), array(0, 0), array(0, 0), array(0, 0), array(0, 0), array(0, 0), array(0, 0), array(0, 0), array(0, 0));
			$checkbox = array(0,0,0,0,0,0,0,0,0,0);

			//walidacja wszystkiego z rokiem lub ilością
			for( $i=0; $i<=9; $i++ ) {
				if (isset($_POST[$pole[$i][0]])) { $result[$i][0] = 1; $_SESSION[$pole[$i][2]] = 1; }
				else { $result[$i][0] = 0; unset($_SESSION[$pole[$i][2]]); }

				if (isset($_POST[$pole[$i][1]])) { $result[$i][1] = $_POST[$pole[$i][1]]; $_SESSION[$pole[$i][3]] = $result[$i][1]; }
				else { $result[$i][1] = 0; unset( $_SESSION[$pole[$i][3]]); }

				if ( $result[$i][0] == 1 && $result[$i][1] == 0 ) {
					$flag = false;
					$_SESSION[$pole[$i][3]] = 0;
					if ($pole[$i][5] == "R") $_SESSION[$pole[$i][4]] = "Zaznaczając to pole musisz wybrać rok!";
					else $_SESSION[$pole[$i][4]] = "Zaznaczając to pole musisz wybrać ilość!";
				} 
			}

			//walidacja checkboxów
			for( $i=10; $i<=19; $i++) {
				if (isset($_POST[$pole[$i][0]])) { $checkbox[$i-10] = 1; $_SESSION[$pole[$i][1]] = 1; }
				else { $checkbox[$i-10] = 0; unset($_SESSION[$pole[$i][1]]); }
			}

			if ($flag == true) {
				$newid = $_SESSION['idsharer'];
				$sql = "UPDATE sharers_formation SET odb1='$checkbox[0]'";
				$sql .= ", odb2='$checkbox[1]'";
				$sql .= ", odb3='$checkbox[2]'";
				$sql .= ", ond1='".$result[0][0]."'";
				$sql .= ", ond1_year='".$result[0][1]."'";
				$sql .= ", ond2='".$result[1][0]."'";
				$sql .= ", ond2_year='".$result[1][1]."'";
				$sql .= ", ond3='".$result[2][0]."'";
				$sql .= ", ond3_year='".$result[2][1]."'";
				$sql .= ", onz1='".$result[3][0]."'";
				$sql .= ", onz1_year='".$result[3][1]."'";
				$sql .= ", onz1bis='".$result[4][0]."'";
				$sql .= ", onz1bis_year='".$result[4][1]."'";
				$sql .= ", deuter='".$result[5][0]."'";
				$sql .= ", deuter_year='".$result[5][1]."'";
				$sql .= ", rek_ew='$checkbox[3]'";
				$sql .= ", lk4='$checkbox[4]'";
				$sql .= ", j8='$checkbox[5]'";
				$sql .= ", erz='$checkbox[6]'";
				$sql .= ", dnz='$checkbox[7]'";
				$sql .= ", kkdc='".$result[6][0]."'";
				$sql .= ", kkdc_amt='".$result[6][1]."'";
				$sql .= ", dw='".$result[7][0]."'";
				$sql .= ", dw_amt='".$result[7][1]."'";
				$sql .= ", om='".$result[8][0]."'";
				$sql .= ", om_amt='".$result[8][1]."'";
				$sql .= ", kwc_cz='".$result[9][0]."'";
				$sql .= ", kwc_cz_year='".$result[9][1]."'";
				$sql .= ", kwc_k='$checkbox[8]'";
				$sql .= ", kwc_not='$checkbox[9]'";
				$sql .= " WHERE id_sharer = $newid";

				$polaczenie->query($sql);
				if ($polaczenie->errno!=0) throw new Exception($polaczenie->error);
				header('Location: registration5.php');
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
				$('#progress').css('width', '80%');
			});
		});
	</script>
</head>
<body>
	<div id="reg">REJESTRACJA</div>
	<div id="frameprogress">
		<div id="progress" style="width: 60%;" ></div>
	</div>
	<div id="main">
		<span class="mainheader">Dotychczasowa formacja</span>
		<span class="inputheader">Rekolekcje</span>
		<form method="post" id="myform">
			<span class="lheader" style="margin-left: 5px;">Oaza Dzieci Bożych</span>
			<div class="inputline">
				<div class="center">
					<div class="check">
						<span class="lheader" style="display: inline;">I&deg</span> <input type="checkbox" name="odb1" id="odb1" <?php 
							if( isset( $_SESSION['remodb1'] ) ) echo 'checked';?> />
					</div>
					<div class="check">
						<span class="lheader" style="display: inline;">II&deg</span> <input type="checkbox" name="odb2" id="odb2" <?php 
							if( isset( $_SESSION['remodb2'] ) ) echo 'checked';?> />
					</div>
					<div class="check">
						<span class="lheader" style="display: inline;">III&deg</span> <input type="checkbox" name="odb3" id="odb3" <?php 
							if( isset( $_SESSION['remodb3'] ) ) echo 'checked';?> />
					</div>
				</div>
			</div>


			<span class="lheader" style="margin-left: 5px;">Oaza Nowej Drogi</span>
			<div class="inputline">
				<div class="center">
					<div class="check">
						<span class="lheader" style="display: inline;">I&deg</span> 
						<input type="checkbox" name="ond1" id="ond1" onchange="showYear()" <?php 
							if( isset( $_SESSION['remond1'] ) ) echo 'checked';?> /> 
					</div>
					<div class="year">
						<select name="ond1y" id="ond1y" <?php if(!isset($_SESSION['remond1y'])) echo 'style="display: none;"'; ?> > 
						 	<?php 
						 		if(!isset($_SESSION['remond1y']) || isset($_SESSION['errond1'])) echo '<option value=\'0\' disabled selected>Rok</option>';
						 		else echo '<option value=\'0\' disabled>Rok</option>';

						 		for($i=date("Y"); $i>=2000; $i--) { 
						 			if( $_SESSION['remond1y'] == $i ) echo "<option selected>".$i."</option>";
						 			else echo "<option>".$i."</option>"; } ?>
						</select>
					</div>
				</div>
			</div>
			<?php 
				 if (isset($_SESSION['errond1'])) {
			     	$val1 = $_SESSION['errond1'];
			    	echo '<div style="clear: both; margin-bottom: 5px; margin-left: 5px;" class="error">'.$val1.'</div>'; 
			    	unset($_SESSION['errond1']); 
				}
			?>
			<div class="inputline">
				<div class="center">
					<div class="check">
						<span class="lheader" style="display: inline;">II&deg</span> 
						<input type="checkbox" name="ond2" id="ond2" onchange="showYear()" <?php 
							if( isset( $_SESSION['remond2'] ) ) echo 'checked';?> /> 
					</div>
					<div class="year">
						<select name="ond2y" id="ond2y" <?php if( !isset($_SESSION['remond2y'])) echo 'style="display: none;"'; ?> > 
						 	<?php 
						 		if(!isset($_SESSION['remond2y']) || isset($_SESSION['errond2'])) echo '<option value=\'0\' disabled selected>Rok</option>';
						 		else echo '<option value=\'0\' disabled>Rok</option>';

						 		for($i=date("Y"); $i>=2000; $i--) { 
						 			if( $_SESSION['remond2y'] == "$i" ) echo "<option selected>".$i."</option>"; 
						 			else echo "<option>".$i."</option>"; } ?>
						</select>
					</div>
				</div>
					
			</div>
			<?php 
				 if (isset($_SESSION['errond2'])) {
			     	$val1 = $_SESSION['errond2'];
			    	echo '<div style="clear: both; margin-bottom: 5px; margin-left: 5px;" class="error">'.$val1.'</div>'; 
			    	unset($_SESSION['errond2']); 
				}
			?>
			<div class="inputline">
				<div class="center">
					<div class="check">
						<span class="lheader" style="display: inline;">III&deg</span> <input type="checkbox" name="ond3" id="ond3" onchange="showYear()" <?php 
							if( isset( $_SESSION['remond3'] ) ) echo 'checked';?> /> 
					</div>
					<div class="year">
						<select name="ond3y" id="ond3y" <?php if(!isset($_SESSION['remond3y'])) echo 'style="display: none;"'; ?> > 
						 	<?php 
						 		if(!isset($_SESSION['remond3y']) || isset($_SESSION['errond3'])) echo '<option value=\'0\' disabled selected>Rok</option>';
						 		else echo '<option value=\'0\' disabled>Rok</option>';

						 		for($i=date("Y"); $i>=2000; $i--) { 
						 			if( $_SESSION['remond3y'] == "$i" ) echo "<option selected>".$i."</option>"; 
						 			else echo "<option>".$i."</option>"; } ?>
						</select>
					</div>
				</div>
			</div>
			<?php 
				 if (isset($_SESSION['errond3'])) {
			     	$val1 = $_SESSION['errond3'];
			    	echo '<div style="clear: both; margin-bottom: 15px;  margin-left: 5px;" class="error">'.$val1.'</div>'; 
			    	unset($_SESSION['errond3']); 
				}
			?>
			<span class="lheader" style="margin-left: 5px;">Oaza Nowego Życia</span>
			<div class="inputline">
				<div class="center">
					<div class="check">
						<span class="lheader" style="display: inline;">I&deg</span> <input type="checkbox" name="onz1" id="onz1" onchange="showYear()" <?php 
							if( isset( $_SESSION['remonz1'] ) ) echo 'checked';?> /> 
					</div>
					<div class="year">
						<select name="onz1y" id="onz1y" <?php if(!isset($_SESSION['remonz1y'])) echo 'style="display: none;"'; ?> > 
						 	<?php 
						 		if(!isset($_SESSION['remonz1y']) || isset($_SESSION['erronz1']))echo '<option value=\'0\' disabled selected>Rok</option>';
						 		else echo '<option value=\'0\' disabled>Rok</option>';

						 		for($i=date("Y"); $i>=2000; $i--) { 
						 			if( $_SESSION['remonz1y'] == "$i" ) echo "<option selected>".$i."</option>"; 
						 			else echo "<option>".$i."</option>"; } ?>
						</select>
					</div>
				</div>
					
			</div>
			<?php 
				 if (isset($_SESSION['erronz1'])) {
			     	$val1 = $_SESSION['erronz1'];
			    	echo '<div style="clear: both; margin-bottom: 15px;  margin-left: 5px;" class="error">'.$val1.'</div>'; 
			    	unset($_SESSION['erronz1']); 
				}
			?>
			<div class="inputline">
				<div class="center">
					<div class="check">
						<span class="lheader" style="display: inline;">I&deg bis</span> <input type="checkbox" name="onz1bis" id="onz1bis" onchange="showYear()" <?php 
							if( isset( $_SESSION['remonz1bis'] ) ) echo 'checked';?> /> 
					</div>
					<div class="year">
						<select name="onz1bisy" id="onz1bisy" <?php if(!isset($_SESSION['remonz1bisy'])) echo 'style="display: none;"'; ?> > 
						 	<?php 
						 		if(!isset($_SESSION['remonz1bisy']) || isset($_SESSION['erronz1bis']))echo '<option value=\'0\' disabled selected>Rok</option>';
						 		else echo '<option value=\'0\' disabled>Rok</option>';

						 		for($i=date("Y"); $i>=2000; $i--) { 
						 			if( $_SESSION['remonz1bisy'] == "$i" ) echo "<option selected>".$i."</option>"; 
						 			else echo "<option>".$i."</option>"; } ?>
						</select>
					</div>
				</div>
					
			</div>
			<?php 
				 if (isset($_SESSION['erronz1bis'])) {
			     	$val1 = $_SESSION['erronz1bis'];
			    	echo '<div style="clear: both; margin-bottom: 15px;  margin-left: 5px;" class="error">'.$val1.'</div>'; 
			    	unset($_SESSION['erronz1bis']); 
				}
			?>
			<div class="inputline">
				<div class="center">
					<div class="check">
						<span class="lheader" style="display: inline;">Przyjęcie do deuterokatechumenatu</span> <input type="checkbox" name="deuter" id="deuter" onchange="showYear()" <?php 
							if( isset( $_SESSION['remdeuter'] ) ) echo 'checked';?> /> 
					</div>
					<div class="year">
						<select name="deutery" id="deutery" <?php if(!isset($_SESSION['remdeutery'])) echo 'style="display: none;"'; ?> > 
						 	<?php 
						 		if(!isset($_SESSION['remdeutery']) || isset($_SESSION['errdeuter']))echo '<option value=\'0\' disabled selected>Rok</option>';
						 		else echo '<option value=\'0\' disabled>Rok</option>';

						 		for($i=date("Y"); $i>=2000; $i--) { 
						 			if( $_SESSION['remdeutery'] == "$i" ) echo "<option selected>".$i."</option>"; 
						 			else echo "<option>".$i."</option>"; } ?>
						</select>
					</div>
				</div>
					
			</div>
			<?php 
				 if (isset($_SESSION['errdeuter'])) {
			     	$val1 = $_SESSION['errdeuter'];
			    	echo '<div style="clear: both; margin-bottom: 15px;  margin-left: 5px;" class="error">'.$val1.'</div>'; 
			    	unset($_SESSION['errdeuter']); 
				}
			?>
			<span class="inputheader" style="margin-top: 10px; margin-bottom: 10px;">Formacja w ciągu roku</span>
			<div class="inputline">
				<div class="center">
					<div class="check">
						<span class="lheader" style="display: inline;">Rekolekcje ewangelizacyjne</span> <input type="checkbox" name="rek_ew" id="rek_ew" onchange="showYear()" <?php 
							if( isset( $_SESSION['remrek_ew'] ) ) echo 'checked';?> /> 
					</div>
				</div>
					
			</div>
			<div class="inputline">
				<div class="center">
					<div class="check">
						<span class="lheader" style="display: inline;">4 spotkania nad ewalgelią św. Łukasza</span> <input type="checkbox" name="lk4" id="lk4" onchange="showYear()" <?php 
							if( isset( $_SESSION['remlk4'] ) ) echo 'checked';?> /> 
					</div>
				</div>
			</div>

			<div class="inputline">
				<div class="center">
					<div class="check">
						<span class="lheader" style="display: inline;">8 spotkań nad ewalgelią św. Jana</span> <input type="checkbox" name="j8" id="j8" onchange="showYear()" <?php 
							if( isset( $_SESSION['remj8'] ) ) echo 'checked';?> /> 
					</div>
				</div>
			</div>

			<div class="inputline">
				<div class="center">
					<div class="check">
						<span class="lheader" style="display: inline;">Ewangeliczne Rewizje Życia po OND I&deg, II&deg, III&deg</span> <input type="checkbox" name="erz" id="erz" onchange="showYear()" <?php 
							if( isset( $_SESSION['remerz'] ) ) echo 'checked';?> /> 
					</div>
				</div>
			</div>

			<div class="inputline">
				<div class="center">
					<div class="check">
						<span class="lheader" style="display: inline;">Droga Nowego Życia (po ONŻ I&deg)</span> <input type="checkbox" name="dnz" id="dnz" onchange="showYear()" <?php 
							if( isset( $_SESSION['remdnz'] ) ) echo 'checked';?> /> 
					</div>
				</div>
			</div>

			<div class="inputline">
				<div class="center">
					<div class="check">
						<span class="lheader" style="display: inline;">Kroki ku dojrzałości chrześcijańskiej</span> <input type="checkbox" name="kkdc" id="kkdc" onchange="showYear()" <?php 
							if( isset( $_SESSION['remkkdc'] ) ) echo 'checked';?> /> 
					</div>
					<div class="year">
						<select name="kkdcamt" id="kkdcamt" <?php if(!isset($_SESSION['remkkdcamt'])) echo 'style="display: none;"'; ?> > 
						 	<?php 
						 		if(!isset($_SESSION['remkkdcamt']) || isset($_SESSION['errkkdc']))echo '<option value=\'0\' disabled selected>Ile</option>';
						 		else echo '<option value=\'0\' disabled>Ile</option>';
						 		for($i=10; $i>=1; $i--) { 
						 			if( $_SESSION['remkkdcamt'] == "$i" ) echo "<option selected>".$i."</option>"; 
						 			else echo "<option>".$i."</option>"; } ?>
						</select>
					</div>
				</div>
			</div>
			<?php 
				 if (isset($_SESSION['errkkdc'])) {
			     	$val1 = $_SESSION['errkkdc'];
			    	echo '<div style="clear: both; margin-bottom: 15px;  margin-left: 5px;" class="error">'.$val1.'</div>'; 
			    	unset($_SESSION['errkkdc']); 
				}
			?>
			<span class="inputheader" style="margin-top: 10px; margin-bottom: 10px;">W minionym roku formacyjnym</span>
			<div class="inputline">
				<div class="center">
					<div class="check">
						<span class="lheader" style="display: inline;">Dni Wspólnoty</span> <input type="checkbox" name="dw" id="dw" onchange="showYear()" <?php 
							if( isset( $_SESSION['remdw'] ) ) echo 'checked';?> /> 
					</div>
					<div class="year">
						<select name="dwamt" id="dwamt" <?php if(!isset($_SESSION['remdwamt'])) echo 'style="display: none;"'; ?> > 
						 	<?php 
						 		if(!isset($_SESSION['remdwamt']) || isset($_SESSION['errdw']))echo '<option value=\'0\' disabled selected>Ile</option>';
						 		else echo '<option value=\'0\' disabled>Ile</option>';

						 		for($i=10; $i>=1; $i--) { 
						 			if( $_SESSION['remdwamt'] == "$i" ) echo "<option selected>".$i."</option>"; 
						 			else echo "<option>".$i."</option>"; } ?>
						</select>
					</div>
				</div>
			</div>
			<?php 
				 if (isset($_SESSION['errdw'])) {
			     	$val1 = $_SESSION['errdw'];
			    	echo '<div style="clear: both; margin-bottom: 15px;  margin-left: 5px;" class="error">'.$val1.'</div>'; 
			    	unset($_SESSION['errdw']); 
				}
			?>
			<div class="inputline">
				<div class="center">
					<div class="check">
						<span class="lheader" style="display: inline;">Oazy Modlitwy</span> <input type="checkbox" name="om" id="om" onchange="showYear()" <?php 
							if( isset( $_SESSION['remom'] ) ) echo 'checked';?> /> 
					</div>
					<div class="year">
						<select name="omamt" id="omamt" <?php if(!isset($_SESSION['remomamt'])) echo 'style="display: none;"'; ?> > 
						 	<?php 
						 		if(!isset($_SESSION['remomamt']) || isset($_SESSION['errom']))echo '<option value=\'0\' disabled selected>Ile</option>';
						 		else echo '<option value=\'0\' disabled>Ile</option>';
						 		for($i=10; $i>=1; $i--) { 
						 			if( $_SESSION['remomamt'] == "$i" ) echo "<option selected>".$i."</option>"; 
						 			else echo "<option>".$i."</option>"; } ?>
						</select>
					</div>
				</div>
			</div>
			<?php 
				 if (isset($_SESSION['errom'])) {
			     	$val1 = $_SESSION['errom'];
			    	echo '<div style="clear: both; margin-bottom: 15px;  margin-left: 5px;" class="error">'.$val1.'</div>'; 
			    	unset($_SESSION['errom']); 
				}
			?>
			<span class="inputheader" style="margin-top: 10px; margin-bottom: 10px;">Krucjata Wyzwolenia Człowieka</span>
			<div class="inputline">
				<div class="center">
					<div class="check">
						<span class="lheader" style="display: inline;">Członek</span> <input type="checkbox" name="kwc_cz" id="kwc_cz" onchange="showYear()" <?php 
							if( isset( $_SESSION['remkwc_cz'] ) ) echo 'checked';?> /> 
					</div>
					<div class="year">
						<select name="kwc_czy" id="kwc_czy" <?php if(!isset($_SESSION['remkwc_czy'])) echo 'style="display: none;"'; ?>> 
						 	<?php 
						 		if(!isset($_SESSION['remkwc_czy']) || isset($_SESSION['errkwc']))echo '<option value=\'0\' disabled selected>Ile</option>';
						 		else echo '<option value=\'0\' disabled>Ile</option>';

						 		for($i=date("Y"); $i>=2000; $i--) {  
						 			if( $_SESSION['remkwc_czy'] == "$i" ) echo "<option selected>".$i."</option>"; 
						 			else echo "<option>".$i."</option>"; } ?>
						</select>
					</div>
				</div>
			</div>
			<?php 
				 if (isset($_SESSION['errkwc'])) {
			     	$val1 = $_SESSION['errkwc'];
			    	echo '<div style="clear: both; margin-bottom: 15px;  margin-left: 5px;" class="error">'.$val1.'</div>'; 
			    	unset($_SESSION['errkwc']); 
				}
			?>
			<div class="inputline">
				<div class="center">
					<div class="check">
						<span class="lheader" style="display: inline;">Kandydat</span> <input type="checkbox" name="kwc_k" id="kwc_k" onchange="showYear()" <?php 
							if( isset( $_SESSION['remkwc_k'] ) ) echo 'checked';?> /> 
					</div>
				</div>
			</div>

			<div class="inputline">
				<div class="center">
					<div class="check">
						<span class="lheader" style="display: inline;">Nie należę </span> <input type="checkbox" name="kwc_not" id="kwc_not" onchange="showYear()" <?php 
							if( isset( $_SESSION['remkwc_not'] ) ) echo 'checked';?> /> 
					</div>
				</div>
			</div>

			
		
			<input type="submit" value="Nastepny krok">
		</form>
	</div>
	<script type="text/javascript">
		<?php
				$fields = array(
					array("#ond1", "#ond1y"), 
					array("#ond2", "#ond2y"), 
					array("#ond3", "#ond3y"), 
					array("#onz1", "#onz1y"), 
					array("#onz1bis", "#onz1bisy"), 
					array("#deuter", "#deutery"),
					array("#kkdc", "#kkdcamt"),
					array("#dw", "#dwamt"),
					array("#om", "#omamt")
				); 

				for ($i = 0; $i < count($fields); $i++) {
				    echo '$(\''.$fields[$i][0].'\').change(function () {';
					echo 'if ($(this).is(\':checked\')) { $(\''.$fields[$i][1].'\').css(\'display\', \'inline-block\'); }'; 
					echo 'else { $(\''.$fields[$i][1].'\').css(\'display\', \'none\'); $(\''.$fields[$i][1].'\').prop(\'selectedIndex\', 0); } });';
				}
		?>
		$('#kwc_cz').change(function () {
			if ($(this).is(':checked')) { 
				$('#kwc_k').prop('checked', false); 
				$('#kwc_not').prop('checked', false);
				$('#kwc_czy').css('display', 'inline'); 
			} else {
				$('#kwc_czy').css('display', 'none'); 
				$('#kwc_czy').prop('selectedIndex', 0);
			}
		});

		$('#kwc_k').change(function () {
			if ($(this).is(':checked')) { 
				$('#kwc_cz').prop('checked', false); 
				$('#kwc_not').prop('checked', false);
				$('#kwc_czy').css('display', 'none'); 
				$('#kwc_czy').prop('selectedIndex', 0);
			}
		});

		$('#kwc_not').change(function () {
			if ($(this).is(':checked')) { 
				$('#kwc_k').prop('checked', false); 
				$('#kwc_cz').prop('checked', false); 
				$('#kwc_czy').css('display', 'none'); 
				$('#kwc_czy').prop('selectedIndex', 0);
			}
		});
	</script>
</body>
</html>