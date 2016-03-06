<?php
	include( "utility.php" );
	include( "setting.php" );

	$ddt = $_POST["DDT"];
	$fornitore = $_POST["Fornitore"];

	$modello = $_POST["Modello"];
	$marca = $_POST["Marca"]; 
	$quantita = $_POST["Quantita"];
	$prezzo = $_POST["Prezzo"];
	$ricarico = $_POST["Ricarico"];
	$univoco = $_POST["Univoco"];
	$sottoCategoria = $_POST["SottoCategoria"]; //da non controllare
	$iva = $_POST["IVA"];

	$header = "Location: ddt.php?DDT=$ddt&Fornitore=$fornitore";	
	
	$error = $_NO_ERROR;

	if( !exactlyMatch( $_REG_CODICE, $modello ) ||
	    //!exactlyMatch( $_REG_NAME, $marca ) ||
		!exactlyMatch( $_REG_NUMERO, $quantita ) ||
		!exactlyMatch( $_REG_PREZZO, $prezzo ) ||
		!exactlyMatch( $_REG_NUMERO, $ricarico ) ||
		!exactlyMatch( $_REG_NUMERO, $univoco ) ||
		!exactlyMatch( $_REG_NUMERO, $iva ) ) 
	{
		$error = $_ERROR;
	}

	if( $error === $_ERROR )
	{
		header( $header.$_ERROR_GET );
		exit;
	}

	$ris_codiceFornitore = mysql_query( "SELECT Codice FROM Fornitore WHERE Ragione_Sociale = '$fornitore';", ConnectDB() );
	$row_codiceFornitore = mysql_fetch_row( $ris_codiceFornitore );

	$risDDT = mysql_query( "SELECT Id FROM DDT WHERE ID_Trasporto = $ddt AND Fornitore = $row_codiceFornitore[0];", ConnectDB() );
	$rowDDT = mysql_fetch_row( $risDDT );
	
	$id_DDT = $rowDDT[0];

	mysql_query( "INSERT INTO Fornito( DDT, Prodotto, Marca, Quantita, Prezzo_Acquisto, Ricarico ) 
				  VALUES( $id_DDT, '$modello', '$marca', $quantita, $prezzo, $ricarico );", ConnectDB() )
	or die( 1 . mysql_error() );

	mysql_query( "CALL AssegnaSottoCat( '$modello', $sottoCategoria );", ConnectDB() )
	or die( 2 . mysql_error() );

	mysql_query( "CALL IdentificaUnivoco( '$modello', $row_codiceFornitore[0], $univoco );", ConnectDB() )
	or die( 3 . mysql_error() );

	if( $iva != "" ) { mysql_query( "UPDATE Prodotto SET IVA = $iva WHERE Modello = '$modello';", ConnectDB() ) or die( 4 . mysql_error() ); }

	header( $header );
?>
