<?php
	include( 'setting.php' );
	include( 'utility.php' );

	$nome = $_POST["Nome"];
	$cognome = $_POST["Cognome"];
	$data = $_POST["Data"];
	$codice = $_POST["Codice"];
	$iva = ( $_POST["IVA"] == "" ) ? "NULL" : $_POST["IVA"];
	$telefono = $_POST["Telefono"];
	$citta = $_POST["Citta"];
	$numero = $_POST["Numero"];
	$via = $_POST["Via"];
	$tessera = ( $_POST["Tessera"] == "" ) ? "NULL" : $_POST["Tessera"];

	if( !exactlyMatch( $_REG_NAME, $nome ) ||
		!exactlyMatch( $_REG_NAME, $cognome ) ||
		!exactlyMatch( $_REG_DATA, $data ) ||
		!exactlyMatch( $_REG_CODICE, $codice ) ||
		( $iva != "NULL" && !exactlyMatch( $_REG_NUMERO, $iva ) ) ||
		!exactlyMatch( $_REG_TELEFONO, $telefono ) ||
		!exactlyMatch( $_REG_NAME, $citta ) ||
		!exactlyMatch( $_REG_NUMERO, $numero ) ||
		!exactlyMatch( $_REG_NAME, $via ) ||
		( $tessera != "NULL" && !exactlyMatch( $_REG_NUMERO, $tessera ) ) ) 
	{
		header( "Location: modifica_utente.php?Error=$_ERROR" );
		exit;
	}

	else
	{
		mysql_query( "UPDATE Cliente_Registrato 
					  SET Nome = '$nome', Cognome = '$cognome', Nascita = '$data', P_IVA = '$iva', Telefono = '$telefono' 
					  WHERE Codice_Fiscale = '$codice';", ConnectDB() );

		$ris_residenza = mysql_query( "SELECT Residenza FROM Cliente_Registrato WHERE Codice_Fiscale = '$codice';", ConnectDB() );
		$row_residenza = mysql_fetch_row( $ris_residenza );
		$residenza = $row_residenza[0];

		mysql_query( "UPDATE Residenza SET Citta = '$citta', Via = '$via', N_Civico = '$numero' WHERE Id = $residenza;", ConnectDB() );

		header( "Location: modifica_utente.php?Error=$_NO_ERROR" );
		exit;
	}
?>
