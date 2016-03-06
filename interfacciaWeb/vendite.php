<!doctype html>
<html>
	<head>
		<style> 
			@import url('style.css') 
		</style>
	</head>
	<?php
		require( 'utility.php' );
		require( 'setting.php' );

		$cliente = NULL;
		$acquisto = NULL;
		$error = false;

		if( isset( $_POST["Cliente"] ) ) $cliente = ( $_POST["Cliente"] == "" ) ? "Vuoto" : $_POST["Cliente"];
		else if( isset( $_GET["Cliente"] ) ) $cliente = $_GET["Cliente"];

		if( $cliente != NULL )
		{
			if( isset( $_POST["Cliente"] ) )
			{
				$insert = ( $cliente == "Vuoto" ) ? "NULL" : $cliente;
				mysql_query( "INSERT INTO Acquisto( Data, Cliente_Registrato ) VALUES( NOW(), '$insert' );", ConnectDB() ) or die( mysql_error() ); 

				$ris_insert = mysql_query( "SELECT LAST_INSERT_ID();", ConnectDB() ) or die( mysql_error() );

				$row_insert = mysql_fetch_row( $ris_insert );
				$acquisto = $row_insert[0]; 
			}

			else
			{
				$acquisto = $_GET["Acquisto"];
				$error = isset( $_GET["Error"] );
			}
		}
	?>
	<body>
		<div class="window">
			<div id="cliente">
				<form method="POST" action="vendite.php">
					<div id="form_cliente">
						<?php
							echo AddInputLabel( "Cliente:", "<input type='text' name='Cliente' value=$cliente>" );
						?>
					</div>
					<div id="submit_cliente">
						<input type="submit" value="Inizia">
					</div>
				</form>
				<?php
					if( isset( $_POST["Cliente"] ) && $cliente == NULL )
					{
						?>
						<div id="errore">
							<div class="error">
								Nessun utente trovato
							</div>
						</div>
						<?php
					}
				?>
			</div>
			<?php
				if( $cliente != NULL )
				{
					?>
					<form method="POST" action="riguarda_acquisti.php">
						<?php 
							echo "<input type='hidden' value='$acquisto' name='Acquisto'>"; 
							echo "<input type='hidden' value='$cliente' name='Cliente'>"; 
						?>
						<div id="vendita">
							<div class="forms_vendita">
								<table>
									<tr>
										<td width=300px> 
											<div class="label"> Prodotto: </div> 
											<div class="form"> <input type="text" size=17 name="Prodotto"> </div> 
										</td>
										<td width=25px></td>
										<td width=275px> 
											<div class="label"> Quantita: </div> 
											<div class="form"> <input type="text" size=10 name="Quantita"> </div> 
										</td>
										<td width=300px> 
											<div class="label"> Prezzo: </div> 
											<div class="form"> <input type="text" size=17 name="Prezzo"> </div> 
										</td>
										<td align="center"> <input type="submit" value="Aggiungi a carrello"> </td>
									</tr>
									<tr>
										<td colspan=5 align="right"> 
											<?php if( $error == true ) echo "Campi non validi"; ?> 
										</td>
									</tr>
								</table>
							</div>

							<div style="padding-top:40px;"></div>			

							<div class="list_product">
								<div id="attribute_product">
									<table align="center">
										<tr>
											<td width=250px> Prodotto </td>
											<td width=250px> Quantita </td>
											<td width=70px> Prezzo Vendita </td>
										<tr>	
									</table>
								</div>
								<div id="view_product" style="height: 350px;">
									<?php
										OpenTable();

										$ris_vendite = mysql_query( "SELECT * FROM Riguarda WHERE Acquisto=$acquisto", 
													    ConnectDB() );

										$color = "#CFCFCF";	

										while( $row = mysql_fetch_row( $ris_vendite ) )
										{
											echo "<tr bgcolor=$color>";
											echo "<td width=250px> $row[1] </td>";
											echo "<td width=250px> $row[2] </td>";
											echo "<td width=70px> $row[3] </td>";
											echo "</tr>";
											$color = ( $color == "#CFCFCF" ) ? "#F3F3F3" : "#CFCFCF";
										} 

										CloseTable();
									?>
								</div>
					
								<div id="line_bottom" style="width: 1010px;"></div>
					
					
								<div id="totale">
									<div id="saldo"> Totale: <br> 9999999,99 </div>		
								</div>
					</form>
								<div id="tools">
									<div class="forms_vendita">
										<table>
											<tr>
												<td> 
													<input type="submit" value="Conferma">
												</td>
												<td> 
													<input type="checkbox" name="Sconto"> Sconto
												</td>
												<td> 
													<select>
													</select>
												</td>
												<td>	
													<input type="radio" name="Uscita"> Scontrino <br>
													<input type="radio" name="Uscita"> Fattura <br>
												</td>
											</tr>
											<tr>
												<td></td>
												<td></td>
												<td></td>
												<td></td>
											</tr>
										</table>
									</div>
								</div>
							</div>
						</div>
					<?php
				}
			?>
		</div>
	</body>
</html>
