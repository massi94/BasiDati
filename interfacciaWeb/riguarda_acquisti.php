<?php
	include( "utility.php" );
	include( "setting.php" );

	$cliente = $_POST["Cliente"];
	$acquisto = $_POST["Acquisto"];

	$prodotto = $_POST["Prodotto"];
	$quantita = $_POST["Quantita"];
	$prezzo = $_POST["Prezzo"];

	$error = false;
	
	if( $prodotto != "" && preg_match( $_REG_NAME, $prodotto ) !== 1 ) $error = true;
	else if( $quantita != "" && preg_match( $_REG_NUMERO, $quantita ) !== 1 ) $error = true;
	
	if( $prezzo != "" && preg_match( $_REG_PREZZO, $prezzo ) !== 1 ) $error = true;
	else if( $prezzo == "" ) $prezzo = 0;
	

	if( $error == true )
	{
		header( "Location: vendite.php?Cliente=$cliente&Acquisto=$acquisto&Error=$_ERROR" );
		exit;
	}
	
	else
	{
		mysql_query( "CALL ProdottiAcquisto( $acquisto, '$prodotto', $quantita, $prezzo )", ConnectDB() );
		header( "Location: vendite.php?Cliente=$cliente&Acquisto=$acquisto );
	}
?>
