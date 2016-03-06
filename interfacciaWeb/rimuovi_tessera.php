<!DOCTYPE html>
<html>
	<head>
		<style>
			@import url( 'style.css' )
		</style>
	</head>
	<?php
		require( 'setting.php' );
		require( 'utility.php' );

		$tessera = "";
		$error = false;
		$delete = false;
		
		if( isset( $_POST["Tessera"] ) ) 
		{ 
			$tessera = $_POST["Tessera"]; 

			$error = ( !exactlyMatch( $_REG_NUMERO, $tessera ) );
		
			if( !$error )
			{
				$ris_existTessera = mysql_query( "SELECT * FROM Tessera WHERE Numero = '$tessera';", ConnectDB() );
			
				if( mysql_num_rows( $ris_existTessera ) > 0 )
				{ 
					mysql_query( "DELETE FROM Tessera WHERE Numero = $tessera;", ConnectDB() ); 
					$delete = true;
				}
				else $error = true;
			}	
		}
	?>
	<body>
		<div id="content_remove">
			<form method="POST" action="rimuovi_tessera.php">
				<div class="input_label">
					<div id="form" style="margin-top: 5px; margin-right: 20px;"> Codice carta: </div>
					<div id="label"> <input type="text" name="Tessera"> </div>
				</div>
				<div id="submit_message">
					<div id="message_error">
						<?php
							if( $error )
							{
								?>
								<div class="error">
									Errore, codice tessera errata
								</div>
								<?php
							}
							else if( $delete )
							{
								?>
								<div class="success">
									Tessera eliminata correttamente
								</div>
								<?php
							}
						?>
					</div>
					<div style="float: left;"> <input type="submit" value="Elimina"> </div>
				</div>
			</form>
		</div>
	</body>
</html>
