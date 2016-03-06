<?php
	include('utility.php');
	include('setting.php');

	$puntiScalati = ( isset( $_POST["Sconto"] ) ) ? -($_POST["Punti"]) : 0;

	$cliente = $_POST["Insert"];
	$acquisto = $_POST["Acquisto"];
	$tipo = ( $_POST["Emissione"] == "Scontrino" ) ? 'S' : 'F';

	mysql_query( "CALL AddPunti( '$cliente', $acquisto, $puntiScalati );", ConnectDB() ) or die( '1'.mysql_error() );

	$ris_dataAcquisto = mysql_query( "SELECT Data FROM Acquisto WHERE Id=$acquisto;", ConnectDB() ) or die( '2'.mysql_error() );
	$row_dataAcquisto = mysql_fetch_row( $ris_dataAcquisto );

	$dataAcquisto = $row_dataAcquisto[0];

	mysql_query( "CALL prRicevuta( $acquisto, '$dataAcquisto', '$tipo' );", ConnectDB() ) or die( '3'.mysql_error() );

	header( "Location: vendite.php?Message=SUCCESS&Acquisto=$acquisto" );
	exit;
?>
