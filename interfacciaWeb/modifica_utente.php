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

		$utente = "";

		if( isset( $_POST["Utente"] ) || isset( $_GET["Utente"] ) )
		{
			$utente = ( isset( $_POST["Utente"] ) ) ? $_POST["Utente"] : $_GET["Utente"];
		}	
	?>
	<body>
		<div style="width: 900px; margin-left: 90px; margin-top: 30px;">
			<fieldset>
				<legend> Tabella anagrafica utente </legend>

					<table>
						<form method="POST" action="modifica_utente.php"> 
							<tr> 
								<td> Codice Fiscale: </td>
							
								<td> <input type="text" name="Utente" value="<?php echo $utente; ?>"> </td>
								<td colspan=4 align="right">
									<input type="submit" value="Seleziona">
								</td>
							</tr>
						</form>
						<form method="POST" action="modify.php">
							<?php
								$datiUtente = array(
									"Nome" => "",		
									"Cognome" => "",
									"Nascita" => "",
									"P_IVA" => "",
									"Telefono" => "",
									"Citta" => "",
								 	"Via" => "",
									"N_Civico" => "",
									"Tessera" => ""
								);

								if( $utente != "" )
								{	
									$ris_datiUtenti = mysql_query( "SELECT Nome, Cognome, Nascita, P_IVA, Telefono, Citta, Via, N_Civico, Numero AS Tessera 
																	FROM ( Cliente_Registrato C JOIN Residenza R ON C.Residenza = R.Id )
																		 LEFT JOIN Tessera T ON C.Codice_Fiscale = T.Cliente_Registrato
																	WHERE C.Codice_Fiscale = '$utente';", ConnectDB() );
									$datiUtente = mysql_fetch_assoc( $ris_datiUtenti );
								}
							?>

							<input type="hidden" value="<?php echo $utente ?>" name="Codice">
							<tr> <td> Nome*: </td> <td> <input type="text" name="Nome" value="<?php echo $datiUtente['Nome'] ?>">  </td> </tr>
							<tr> <td> Cognome*: </td> <td> <input type="text" name="Cognome" value="<?php echo $datiUtente['Cognome'] ?>"> </td> </tr>
							<tr> <td> Data di nascita*: </td> <td> <input type="text" name="Data" value="<?php echo $datiUtente['Nascita'] ?>"> </td> </tr>
							<tr> <td> Partita IVA: </td> <td> <input type="text" name="IVA" value="<?php echo $datiUtente['P_IVA'] ?>"> </td> </tr>
							<tr> <td> Telefono*: </td> <td> <input type="text" name="Telefono" value="<?php echo $datiUtente['Telefono'] ?>"> </td> </tr>
							<tr> 
								<td> Citta*: </td> <td> <input type="text" name="Citta" value="<?php echo $datiUtente['Citta'] ?>">  </td>
								<td> Numero*: </td> <td> <input type="text" size=4 name="Numero" value="<?php echo $datiUtente['N_Civico'] ?>">  </td> 
								<td> Via*: </td> <td> <input type="text" name="Via" value="<?php echo $datiUtente['Via'] ?>"> </td> 
							</tr>
							<tr> <td> Codice Tessera: </td> <td> <input type="text" name="Tessera" value="<?php echo $datiUtente['Tessera']; ?>" DISABLED> </td> </tr>
							<tr> 
								<td colspan=5> 
									<?php 
										if( isset( $_GET["Error"] ) )
										{
											if( $_GET["Error"] == $_ERROR ) echo "<div class='error'> Errore, uno o piu' campi sono sbagliati </div>"; 
											else echo "<div class='success'> Modifica eseguita </div>";
										} 
									?> 
								</td>
								<td colspan=6 align=right> 
									<div style="margin-right: 15px;"> 
										<input type="submit" value="Modifica">
									</div> 
								</td> 
							</tr>
						</form>
					</table>

			</fieldset>
		</div>
	</body>
</html>
