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
	<link rel="stylesheet" type="text/css" href="fontello/css/fontello.css" />
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
				<a href="#"> <div class="choice">Moje dane</div> </a>
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
				<div id="name"> 
					<?php 
						$second_name = '';
						if ($_SESSION['second_name'] != '') $second_name = $_SESSION['second_name'].' ';

						$fullname = $_SESSION['name'].' '.$second_name.$_SESSION['surname'];
						echo $fullname;
					 ?>
				</div>
				<div id="dane">
					<span class="table_header">Dane osobowe</span>
					<table>
						<tr>
							<td style="font-weight: 500;">Imię i nazwisko</td>
							<td><?php echo $fullname; ?></td>
						</tr>
						<tr>
							<td style="font-weight: 500;">PESEL</td>
							<td><?php echo $_SESSION['pesel']; ?></td>
						</tr>
						<tr>
							<td style="font-weight: 500;">Data urodzenia</td>
							<td>
								<?php 
								if ($_SESSION['birth_month'] < 10) $month = '0'.$_SESSION['birth_month'];
								else $month =  $_SESSION['birth_month'];
								echo  $_SESSION['birth_day'].'.'.$month.'.'. $_SESSION['birth_year'].' r.';
								?>
							</td>
						</tr>
						<tr>
							<td style="font-weight: 500;">Data imienin</td>
							<td>
								<?php 
								$miesiace = array('stycznia', 'lutego', 'marca', 'kwietnia', 'maja', 'czerwca', 'lipca', 'sierpnia', 'września', 'października', 'listopada', 'grudnia');
								echo $_SESSION['nameday_day'].' '.$miesiace[$_SESSION['nameday_month'] - 1];
								?>
							</td>
						</tr>
						<tr>
							<td style="font-weight: 500;">Email</td>
							<td><?php echo $_SESSION['email']; ?></td>
						</tr>
						<tr>
							<td style="font-weight: 500;">Telefon</td>
							<td><?php echo $_SESSION['phone_number']; ?></td>
						</tr>
						<tr>
							<td style="font-weight: 500;">Adres</td>
							<td><?php echo $_SESSION['address_street'].'</br>'.$_SESSION['address_postcode'].' '.$_SESSION['address_city']; ?></td>
						</tr>
					</table>

					<span class="table_header">Edukacja</span>
					<table>
						<tr>
							<td class="first">Po klasie</td>
							<td><?php echo $_SESSION['after_class']; ?></td>
						</tr>
						<tr>
							<td class="first">Szkoła</td>
							<td><?php echo $_SESSION['school']; ?></td>
						</tr>
					</table>

					<span class="table_header">Parafia i wspólnota</span>
					<table>
						<tr>
							<td class="first">Parafia</td>
							<td><?php echo $_SESSION['parish']; ?></td>
						</tr>
						<tr>
							<td class="first">Diecezja</td>
							<td><?php echo $_SESSION['diocese']; ?></td>
						</tr>
						<tr>
							<td class="first">Oaza w parafii</td>
							<td><?php echo $_SESSION['oaza_parish']; ?></td>
						</tr>
					</table>

					<span class="table_header">Formacja</span>

					<?php 
						function reko($name, $year) {
							if ($year != -1) {
								if($name) echo '<td><i class="icon-ok"></i></td><td>'.$year.'</td>';
								else echo '<td colspan="2"><i class="icon-cancel"></i></td>';
							} else {
								if($name) echo '<td colspan="2"><i class="icon-ok"></i></td>';
								else echo '<td colspan="2"><i class="icon-cancel"></i></td>';
							}
						}
					?>

					<table style="text-align: center;">
						<tr>
							<td class="first">ODB I</td>
							<?php reko($_SESSION['odb1'], -1); ?>
							<td class="first">ODB II</td>
							<?php reko($_SESSION['odb2'], -1); ?>
							<td class="first">ODB III</td>
							<?php reko($_SESSION['odb3'], -1); ?>
						</tr>
						<tr>
							<td class="first">OND I</td>
							<?php reko($_SESSION['ond1'], $_SESSION['ond1_year']); ?>
							<td class="first">OND II</td>
							<?php reko($_SESSION['ond2'], $_SESSION['ond2_year']); ?>
							<td class="first">OND III</td>
							<?php reko($_SESSION['ond3'], $_SESSION['ond3_year']); ?>
						</tr>
						<tr>
							<td class="first">ONŻ I</td>
							<?php reko($_SESSION['onz1'], $_SESSION['onz1_year']); ?>
							<td class="first">ONŻ I bis</td>
							<?php reko($_SESSION['onz1bis'], $_SESSION['onz1bis_year']); ?>
						</tr>
						<tr style="height: 20px;"> </tr>

						<?php 
							function one_row($name, $year_amt) {
								if ($year_amt != -1) {
									if($name) 
										echo '<td><i class="icon-ok"></i></td><td>'.$year_amt.'</td>';
									else echo '<td colspan="2"><i class="icon-cancel"></i></td>';
								} else {
									if($name) echo '<td colspan="2"><i class="icon-ok"></i></td>';
									else echo '<td colspan="2"><i class="icon-cancel"></i></td>';
								}
							}
						?>
						<tr>
							<td colspan="4">Przyjęcie deuterokatechumenatu</td>
							 <?php one_row($_SESSION['deuter'], $_SESSION['deuter_year']); ?>
						</tr>
						<tr>
							<td colspan="4">Rekolekcje ewangelizacyjne</td>
							<?php one_row($_SESSION['rek_ew'], -1); ?>
						</tr>
						<tr>
							<td colspan="4">4 spotkania nad ewangelią św. Łukasza</td>
							<?php one_row($_SESSION['lk4'], -1); ?>
						</tr>
						<tr>
							<td colspan="4">8 spotkań nad ewangelią św. Łukasza</td>
							<?php one_row($_SESSION['j8'], -1); ?>
						</tr>
						<tr>
							<td colspan="4">Ewangeliczne Rewizje Życia po OND I, II, III</td>
							<?php one_row($_SESSION['erz'], -1); ?>
						</tr>
						<tr>
							<td colspan="4">Droga Nowego Życia (po ONŻ I)</td>
							<?php one_row($_SESSION['dnz'], -1); ?>
						</tr>
						<tr>
							<td colspan="4">Kroki ku dojrzałości chrześcijańskiej</td>
							<?php one_row($_SESSION['kkdc'], $_SESSION['kkdc_amt']); ?>
						</tr>
						<tr>
							<td colspan="4">Dni Wspólnoty</td>
							<?php one_row($_SESSION['dw'], $_SESSION['dw_amt']); ?>

						</tr>
						<tr>
							<td colspan="4">Oazy Modlitwy</td>
							<?php one_row($_SESSION['om'], $_SESSION['om_amt']); ?>

						</tr>
						<tr style="height: 20px;"> </tr>
						<tr>
							<td colspan="4">Krucjata Wyzwolenia Człowieka</td>
							<?php
								if($_SESSION['kwc_not'] || ($_SESSION['kwc_not'] == 0 && $_SESSION['kwc_cz'] == 0 && $_SESSION['kwc_k'] == 0))
									echo '<td colspan="2"><i class="icon-cancel"></i></td>';
								else
								{
									if($_SESSION['kwc_k'])
										echo '<td colspan="2">kandydat</i></td>';
									if($_SESSION['kwc_cz'])
										echo '<td colspan="2">członek</i></td><td>'.$_SESSION['kwc_cz_year'].'</td>';
								}
							 ?>
						</tr>
					</table>
					
					<br />
					<a href="karta/form.php">Pobierz swoją kartę</a>
				</div>
			</div>
			
		</div>
	
	
</body>
</html>

<!--
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

	echo " Po klasie : " . $_SESSION['after_class'] . "<br/>";
	echo " Szkoła : " . $_SESSION['school'] . "<br/>";
	echo " Parafia : " . $_SESSION['parish'] . "<br/>";
	echo " Diecezja : " . $_SESSION['diocese'] . "<br/>";
	echo " Oaza parafia : " . $_SESSION['oaza_parish'] . "<br/>";

	echo " ODB 1 : " . $_SESSION['odb1'] . "<br/>";
	echo " ODB 2 : " . $_SESSION['odb2'] . "<br/>";
	echo " ODB 3 : " . $_SESSION['odb3'] . "<br/>";

	echo " OND 1 : " . $_SESSION['ond1'] . "<br/>";
	echo " OND 1 rok : " . $_SESSION['ond1_year'] . "<br/>";
	echo " OND 2 : " . $_SESSION['ond1'] . "<br/>";
	echo " OND 2 rok : " . $_SESSION['ond2_year'] . "<br/>";
	echo " OND 3 : " . $_SESSION['ond3'] . "<br/>";
	echo " OND 3 rok : " . $_SESSION['ond3_year'] . "<br/>";

	echo " ONŻ 1 : " . $_SESSION['onz1'] . "<br/>";
	echo " ONŻ rok : " . $_SESSION['onz1_year'] . "<br/>";
	echo " ONŻ 1 bis: " . $_SESSION['onz1bis'] . "<br/>";
	echo " ONŻ bis rok : " . $_SESSION['onz1bis_year'] . "<br/>";
	echo " Deuterokatechumenat : " . $_SESSION['deuter'] . "<br/>";
	echo " Deuterokatechumenat rok : " . $_SESSION['deuter_year'] . "<br/>";
	echo " Rek_ew : " . $_SESSION['rek_ew'] . "<br/>";
	echo " Łk4 : " . $_SESSION['lk4'] . "<br/>";
	echo " J8 : " . $_SESSION['j8'] . "<br/>";
	echo " ERŻ : " . $_SESSION['erz'] . "<br/>";
	echo " DNŻ : " . $_SESSION['dnz'] . "<br/>";
	echo " KKDC : " . $_SESSION['kkdc'] . "<br/>";
	echo " KKDC Ilość : " . $_SESSION['kkdc_amt'] . "<br/>";
	echo " DW : " . $_SESSION['dw'] . "<br/>";
	echo " DW Ilość : " . $_SESSION['dw_amt'] . "<br/>";
	echo " OM : " . $_SESSION['om'] . "<br/>";
	echo " OM Ilość : " . $_SESSION['om_amt'] . "<br/>";
	echo " KWC Członek : " . $_SESSION['kwc_cz'] . "<br/>";
	echo " KWC Członek rok : " . $_SESSION['kwc_cz_year'] . "<br/>";
	echo " KWC Kandydat : " . $_SESSION['kwc_k'] . "<br/>";
	echo " KWC Nie: " . $_SESSION['kwc_not'] . "<br/>";	
-->