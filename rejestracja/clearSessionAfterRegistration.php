<?php
	session_start();

	if (isset($_SESSION['reginprogress'])) unset($_SESSION['reginprogress']);
	if (isset($_SESSION['idsharer'])) unset($_SESSION['idsharer']);

	if (isset($_SESSION['rememail'])) unset($_SESSION['rememail']);
	if (isset($_SESSION['remhaslo1'])) unset($_SESSION['remhaslo1']);
	if (isset($_SESSION['remhaslo2'])) unset($_SESSION['remhaslo2']);

	if (isset($_SESSION['remname'])) unset($_SESSION['remname']);
	if (isset($_SESSION['remsecname'])) unset($_SESSION['remsecname']);
	if (isset($_SESSION['remsurname'])) unset($_SESSION['remsurname']);
	if (isset($_SESSION['remstreet'])) unset($_SESSION['remstreet']);
	if (isset($_SESSION['rempostcode'])) unset($_SESSION['rempostcode']);
	if (isset($_SESSION['remcity'])) unset($_SESSION['remcity']);
	if (isset($_SESSION['rembday'])) unset($_SESSION['rembday']);
	if (isset($_SESSION['rembmonth'])) unset($_SESSION['rembmonth']);
	if (isset($_SESSION['rembyear'])) unset($_SESSION['rembyear']);
	if (isset($_SESSION['remnday'])) unset($_SESSION['remnday']);
	if (isset($_SESSION['remnmonth'])) unset($_SESSION['remnmonth']);
	if (isset($_SESSION['rempesel'])) unset($_SESSION['rempesel']);
	if (isset($_SESSION['remphone'])) unset($_SESSION['remphone']);

	if (isset($_SESSION['remaclass'])) unset($_SESSION['remaclass']);
	if (isset($_SESSION['remstype'])) unset($_SESSION['remstype']);
	if (isset($_SESSION['remschool'])) unset($_SESSION['remschool']);
	if (isset($_SESSION['remparish'])) unset($_SESSION['remparish']);
	if (isset($_SESSION['remdiocese'])) unset($_SESSION['remdiocese']);
	if (isset($_SESSION['remoparish'])) unset($_SESSION['remoparish']);
	
	if (isset($_SESSION['remodb1'])) unset($_SESSION['remodb1']);
	if (isset($_SESSION['remodb2'])) unset($_SESSION['remodb2']);
	if (isset($_SESSION['remodb3'])) unset($_SESSION['remodb3']);
	if (isset($_SESSION['remond1'])) unset($_SESSION['remond1']);
	if (isset($_SESSION['remond1y'])) unset($_SESSION['remond1y']);
	if (isset($_SESSION['remond2'])) unset($_SESSION['remond2']);
	if (isset($_SESSION['remond2y'])) unset($_SESSION['remond2y']);
	if (isset($_SESSION['remond3'])) unset($_SESSION['remond3']);
	if (isset($_SESSION['remond3y'])) unset($_SESSION['remond3y']);
	if (isset($_SESSION['remonz1'])) unset($_SESSION['remonz1']);
	if (isset($_SESSION['remonz1y'])) unset($_SESSION['remonz1y']);
	if (isset($_SESSION['remonz1bis'])) unset($_SESSION['remonz1bis']);
	if (isset($_SESSION['remonz1bisy'])) unset($_SESSION['remonz1bisy']);
	if (isset($_SESSION['remdeuter'])) unset($_SESSION['remdeuter']);
	if (isset($_SESSION['remdeutery'])) unset($_SESSION['remdeutery']);
	if (isset($_SESSION['remrek_ew'])) unset($_SESSION['remrek_ew']);
	if (isset($_SESSION['remlk4'])) unset($_SESSION['remlk4']);
	if (isset($_SESSION['remj8'])) unset($_SESSION['remj8']);
	if (isset($_SESSION['remerz'])) unset($_SESSION['remerz']);
	if (isset($_SESSION['remdnz'])) unset($_SESSION['remdnz']);
	if (isset($_SESSION['remkkdc'])) unset($_SESSION['remkkdc']);
	if (isset($_SESSION['remkkdcamt'])) unset($_SESSION['remkkdcamt']);
	if (isset($_SESSION['remdw'])) unset($_SESSION['remdw']);
	if (isset($_SESSION['remdwamt'])) unset($_SESSION['remdwamt']);
	if (isset($_SESSION['remom'])) unset($_SESSION['remom']);
	if (isset($_SESSION['remomamt'])) unset($_SESSION['remomamt']);
	if (isset($_SESSION['remkwc_cz'])) unset($_SESSION['remkwc_cz']);
	if (isset($_SESSION['remkwc_czy'])) unset($_SESSION['remkwc_czy']);
	if (isset($_SESSION['remkwc_k'])) unset($_SESSION['remkwc_k']);
	if (isset($_SESSION['remkwc_not'])) unset($_SESSION['remkwc_not']);
?>