<!DOCTYPE html>
<html>
	<head>
		<style>
			@import url( 'style.css' )
		</style>
	</head>
	<?php
		require( 'setting.php' );	
	?>
	<body>
		<div style="width: 900px; margin-left: 90px; margin-top: 30px;">
			<form method="POST" action="insert.php">
				<fieldset>
					<legend> Tabella anagrafica utente </legend>
						<table>
							<tr> <td> Nome*: </td> <td> <input type="text" name="Nome"> </td> </tr>
							<tr> <td> Cognome*: </td> <td> <input type="text" name="Cognome"> </td> </tr>
							<tr> <td> Data di nascita*: </td> <td> <input type="text" name="Data"> </td> </tr>
							<tr> <td> Codice fiscale*: </td> <td> <input type="text" name="Codice"> </td> </tr>
							<tr> <td> Partita IVA: </td> <td> <input type="text" name="IVA"> </td> </tr>
							<tr> <td> Telefono*: </td> <td> <input type="text" name="Telefono"> </td> </tr>
							<tr> 
								<td> Citta*: </td> <td> <input type="text" name="Citta"> </td>
								<td> Numero*: </td> <td> <input type="text" size=4 name="Numero"> </td> 
								<td> Via*: </td> <td> <input type="text" name="Via"> </td> 
							</tr>
							<tr> <td> Codice Tessera: </td> <td> <input type="text" name="Tessera"> </td> </tr>
							<tr> 
								<td colspan=5> 
									<?php 
										if( isset( $_GET["Error"] ) )
										{
											if( $_GET["Error"] == $_ERROR ) echo "<div class='error'> Errore, uno o piu' campi sono sbagliati </div>"; 
											else echo "<div class='success'> Registrazione eseguita </div>";
										} 
									?> 
								</td>
								<td colspan=6 align=right> 
									<div style="margin-right: 15px;"> 
										<input type="submit" value="Aggiungi">
									</div> 
								</td> 
							</tr>
						</table>
				</fieldset>
			</form>
		</div>
	</body>
</html>
