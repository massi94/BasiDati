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

	$error = false;

	if( !exactlyMatch( $_REG_NAME, $nome ) ) $error = "nome";
	else if( !exactlyMatch( $_REG_NAME, $cognome ) ) $error = "cognome";
	else if( !exactlyMatch( $_REG_DATA, $data ) ) $error = "data";
	else if( !exactlyMatch( $_REG_CODICE, $codice ) ) $error = "codice";
	else if( $iva != "NULL" && !exactlyMatch( $_REG_NUMERO, $iva ) ) $error = "iva";
	else if( !exactlyMatch( $_REG_TELEFONO, $telefono ) ) $error = "telefono";
	else if( !exactlyMatch( $_REG_NAME, $citta ) ) $error = "citta";
	else if( !exactlyMatch( $_REG_NUMERO, $numero ) ) $error = "numero";
	else if( !exactlyMatch( $_REG_NAME, $via ) ) $error = "via";
	else if( $tessera != "NULL" && !exactlyMatch( $_REG_NUMERO, $tessera ) ) $error = "tessera";

	if( $error == true )
	{
		header( "Location: aggiunta_utente.php?Error=$_ERROR" );
		exit;
	}
	else
	{
		mysql_query( "INSERT INTO Residenza( Citta, Via, N_Civico ) VALUES( '$citta', '$via', $numero );", ConnectDB() );
		 
		$ris_residenza = mysql_query( "SELECT Id FROM Residenza WHERE Citta = '$citta' AND Via = '$via' AND N_Civico = $numero;", ConnectDB() );
		$row_residenza = mysql_fetch_row( $ris_residenza );
		$residenza = $row_residenza[0];

		mysql_query( "INSERT INTO Cliente_Registrato( Codice_Fiscale, Nome, Cognome, Nascita, P_IVA, Residenza, Telefono ) 
					  VALUES( '$codice', '$nome', '$cognome', '$data', $iva, $residenza, '$telefono' );", ConnectDB() );

		if( $tessera != "NULL" ) mysql_query( "INSERT INTO Tessera( Numero, Cliente_Registrato ) VALUES( $tessera, '$codice' );", ConnectDB() );

		header( "Location: aggiunta_utente.php?Error=$_NO_ERROR" );
		exit;
	}
?>
