<?php
	include( 'utility.php' );
	include( 'setting.php' );

	$user = $_POST["Codice"];
	$tessera = $_POST["Tessera"];

	$error = false;

	if( !exactlyMatch( $_REG_CODICE, $user ) && !exactlyMatch( "/[a-z]{1,}/", $user ) ) $error = true;
	else if( !exactlyMatch( $_REG_NUMERO, $tessera ) ) $error = true;

	if( $error )
	{
		header( "Location: utente.php?Error=$_ERROR" );
		exit;
	}
	
	else
	{
		$admin = mysql_query( "SELECT * FROM Amministratore WHERE Utente = '$user' AND Password = '$tessera';", ConnectDB() );

		if( mysql_num_rows( $admin ) == 1 )
		{
			header( "Location: admin.php" );
			exit;
		}
			
		else
		{
			$ris_users = mysql_query( "SELECT * FROM Tessera WHERE Numero = $tessera AND Cliente_Registrato = '$user';", ConnectDB() );

			if( mysql_num_rows( $ris_users ) == 1 )
			{
				header( "Location: accesso_utente.php?Utente=$user" );
				exit;
			}

			else
			{
				header( "Location: utente.php?Error=$_ERROR" );
				exit;
			}
		}
	}
?>
