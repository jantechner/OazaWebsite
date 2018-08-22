<?php 
	session_start();  //do globalnej tablicy asocjacyjnej

	if ( (!isset($_POST['login'])) || (!isset($_POST['haslo']))) {
		header('Location: logIndex.php');
		exit();
	}

	require_once "../connect.php";

	unset($_SESSION['blad']);

	$polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
	if ($polaczenie->connect_errno!=0) {
		echo "Error: " . $polaczenie->connect_errno;
		//wyślij na podstronę z informacją o błędzie
	} else {
		$polaczenie->set_charset("utf8");
		$login = htmlentities($_POST['login'], ENT_QUOTES, "UTF-8");
		$haslo = $_POST['haslo'];
		$_SESSION['remlogemail'] = $login;
		$_SESSION['remlogpassword'] = $haslo;

		$check_sharers = $polaczenie->query(sprintf("SELECT 1 FROM sharers_log WHERE email = '%s'", mysqli_real_escape_string($polaczenie, $login)));

		if ( $check_sharers->num_rows > 0 ) {
			//połączenie z bazą danych uczestników i ustawienie zmiennych sesji 
			$log_table = 'sharers_log';
			$personal_table = 'sharers_personal';
			$school_table = 'sharers_school';
			$formation_table = 'sharers_formation';

			$sql_str = "SELECT * FROM %s AS l, %s AS p, %s AS s, %s AS f WHERE l.id_sharer = p.id_sharer AND s.id_sharer = p.id_sharer AND f.id_sharer = p.id_sharer AND l.email = '%s'";
			if ( $result = @$polaczenie->query(sprintf($sql_str, $log_table, $personal_table, $school_table, $formation_table, mysqli_real_escape_string($polaczenie, $login)))) {
				$wiersz = $result->fetch_assoc();

				//if ( password_verify($haslo, $wiersz['pass']) == true) {
				if ( $haslo == $wiersz['password']) {

					$_SESSION['id_sharer'] = $wiersz['id_sharer'];
					
					//log
					$_SESSION['email'] = $wiersz['email'];
					$_SESSION['password'] = $wiersz['password'];

					//personal
					$_SESSION['name'] = $wiersz['name'];
					$_SESSION['surname'] = $wiersz['surname'];
					$_SESSION['second_name'] = $wiersz['second_name'];
					$_SESSION['pesel'] = $wiersz['pesel'];
					$_SESSION['phone_number'] = $wiersz['phone_number'];
					$_SESSION['address_street'] = $wiersz['address_street'];
					$_SESSION['address_postcode'] = $wiersz['address_postcode'];
					$_SESSION['address_city'] = $wiersz['address_city'];
					$_SESSION['birth_day'] = $wiersz['birth_day'];
					$_SESSION['birth_month'] = $wiersz['birth_month'];
					$_SESSION['birth_year'] = $wiersz['birth_year'];
					$_SESSION['nameday_day'] = $wiersz['nameday_day'];
					$_SESSION['nameday_month'] = $wiersz['nameday_month'];

					//school
					$_SESSION['after_class'] = $wiersz['after_class'];
					$_SESSION['school'] = $wiersz['school'];
					$_SESSION['parish'] = $wiersz['parish'];
					$_SESSION['diocese'] = $wiersz['diocese'];
					$_SESSION['oaza_parish'] = $wiersz['oaza_parish'];

					//formation
					$_SESSION['odb1'] = $wiersz['odb1'];
					$_SESSION['odb2'] = $wiersz['odb2'];
					$_SESSION['odb3'] = $wiersz['odb3'];

					$_SESSION['ond1'] = $wiersz['ond1'];
					$_SESSION['ond1_year'] = $wiersz['ond1_year'];
					$_SESSION['ond2'] = $wiersz['ond2'];
					$_SESSION['ond2_year'] = $wiersz['ond2_year'];
					$_SESSION['ond3'] = $wiersz['ond3'];
					$_SESSION['ond3_year'] = $wiersz['ond3_year'];

					$_SESSION['onz1'] = $wiersz['onz1'];
					$_SESSION['onz1_year'] = $wiersz['onz1_year'];
					$_SESSION['onz1bis'] = $wiersz['onz1bis'];
					$_SESSION['onz1bis_year'] = $wiersz['onz1bis_year'];
					$_SESSION['deuter'] = $wiersz['deuter'];
					$_SESSION['deuter_year'] = $wiersz['deuter_year'];
					$_SESSION['rek_ew'] = $wiersz['rek_ew'];
					$_SESSION['lk4'] = $wiersz['lk4'];
					$_SESSION['j8'] = $wiersz['j8'];

					$_SESSION['erz'] = $wiersz['erz'];
					$_SESSION['dnz'] = $wiersz['dnz'];
					$_SESSION['kkdc'] = $wiersz['kkdc'];
					$_SESSION['kkdc_amt'] = $wiersz['kkdc_amt'];
					$_SESSION['dw'] = $wiersz['dw'];
					$_SESSION['dw_amt'] = $wiersz['dw_amt'];
					$_SESSION['om'] = $wiersz['om'];
					$_SESSION['om_amt'] = $wiersz['om_amt'];
					$_SESSION['kwc_cz'] = $wiersz['kwc_cz'];
					$_SESSION['kwc_cz_year'] = $wiersz['kwc_cz_year'];
					$_SESSION['kwc_k'] = $wiersz['kwc_k'];
					$_SESSION['kwc_not'] = $wiersz['kwc_not'];
					
					$_SESSION['zalogowany'] = true;
					unset($_SESSION['remlogemail']);
					unset($_SESSION['remlogpassword']);

					$result->close(); //zakończ zapytanie
					header('Location: ../uczestnik/uczestnik.php');
				} else {
					//błędne hasło
					$_SESSION['blad'] = '<span style = "color:red;">Nieprawidłowe hasło!</span>';
					unset($_SESSION['remlogpassword']);
					header('Location: log.php');
				}
			}
		} else {
			//brak osoby o danym loginie 
			$_SESSION['blad'] = '<span style = "color:red;">Niepoprawny login!</span>';
			header('Location: log.php');
		}
		$polaczenie->close();
	}
?>