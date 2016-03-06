<html> 
	<head>
		<style>
			@import url( 'style.css' )
		</style>
	</head>
	<?php
		require( 'utility.php' );
        require( 'setting.php' );

		$ddt = "";
		$sel_fornitore = "";
		$codiceFornitore = -1;

		$error = $_NO_ERROR;

		if( isset( $_POST["DDT"] ) || isset( $_GET["DDT"] ) )
		{
			$sel_fornitore = ( isset( $_POST["DDT"] ) ) ? $_POST["Fornitore"] : $_GET["Fornitore"];

			$risFornitore = mysql_query( "SELECT Codice FROM Fornitore WHERE Ragione_Sociale = '$sel_fornitore';", ConnectDB() );
			$rowFornitore = mysql_fetch_row( $risFornitore );	

			$codiceFornitore = $rowFornitore[0];

			if( isset( $_POST["DDT"] ) )
			{
				$ddt = $_POST["DDT"];
				
				if( preg_match( "/[0-9]{1,}/", $ddt ) !== 1 )
				{
					$ddt = "";
					$error = $_ERROR;
				}

				else
				{
					mysql_query( "INSERT INTO DDT( ID_Trasporto, Data, Fornitore ) VALUES( $ddt, NOW(), $codiceFornitore );", ConnectDB() );
				}
			}

			else if( isset( $_GET["DDT"] ) )
			{
				$ddt = $_GET["DDT"];
				if( isset( $_GET["Error"] ) ) $error = $_ERROR;
			}
		}
	?>
	<body style="overflow-x: hidden;">
		<div class="window">
			<form method="POST" action="ddt.php"> <!-- Campi di registrazione DDT -->
				<div class="top_bar">
					<div id="ddt">
						<div class="input_text">
							<div id="label"> DDT: </div>
							<div id="form"> <input type="text" name="DDT" size=15 value="<?php echo $ddt ?>"> </div>				
						</div>	
					</div>
					<div id="fornitore">
						<div class="input_text">
						    <div id="label">
						        Fornitori:
						    </div>
						    <div id="form">
						        <fieldset style="border-width: 0px; padding: 0;">
						            <select name="Fornitore">
						                <?php
											$fornitore = mysql_query( "SELECT Ragione_Sociale FROM Fornitore;", ConnectDB() );

											while( $row = mysql_fetch_row( $fornitore ) )
											{
												if( $sel_fornitore == $row[0] ) echo "<option selected>";
												else echo "<option>";

												echo " $row[0] </option>";
											} 
										?>
						            </select>
						        </fieldset>
						    </div>
						</div>	
					</div>	
					<?php
						if( $error == $_ERROR && $ddt == "" ) PrintError( "Errore, DDT non valido" ); //errore in post
					?>
					<div id="registra">
						<input type="submit" value="Registra">
					</div>	 	 
				</div>
			</form>	<!-- Campi di registrazione DDT -->
			<div id="ddt_value"> <!-- Campo descrizione prodotto DDT -->
				<?php
					if( $ddt != "" )
					{
						echo "<form method='POST' action='register.php'> ";

						echo "<input type='hidden' value=$ddt name='DDT'>";
						echo "<input type='hidden' value=$sel_fornitore name='Fornitore'>";

						OpenTable();
					
						AddRow( array( AddInputLabel( "Modello:", "<input type='text' name='Modello'>" ),
									   AddInputLabel( "Marca:", "<input type='text' name='Marca'>" ),
									   AddInputLabel( "Quantita:", "<input type='text' name='Quantita'" ) ) );	

						AddRow( array( AddInputLabel( "Prezzo:", "<input type='text' name='Prezzo'>" ),
									   AddInputLabel( "Ricarico:", "<input type='text' name='Ricarico'>" ),
									   AddInputLabel( "Univoco:", "<input type='text' name='Univoco'" ) ) );

						$category = mysql_query( "SELECT Nome FROM Categoria", ConnectDB() );

						$listCategory = "<select name='SottoCategoria'>";

						while( $nameCategory = mysql_fetch_row( $category ) )
						{
							$listCategory .= "<optgroup label='$nameCategory[0]'>";

							$subCategory = mysql_query( "SELECT Id, Nome FROM Sotto_Categoria WHERE Categoria = '$nameCategory[0]';", ConnectDB() );
						
							while( $rowSubCategory = mysql_fetch_row( $subCategory ) )
							{
								$listCategory .= "<option value='$rowSubCategory[0]'> $rowSubCategory[1] </option>";
							} 
						
							$listCategory .= "</optgroup>";
						}
	
						$listCategory .= "</select>";
				
						?>
						<tr>
							<td> <?php echo AddInputLabel( "Categoria:", $listCategory ) ?> </td>
							<td align="center"> 
								<?php if( $error == $_ERROR ) PrintError( "Alcuni campi non sono validi" ); ?> 
							</td>							
							<td align="center"> <input type="submit" value="Aggiungi"> </td>
						</tr>
						<?php

						CloseTable();

						echo "</form>";							
						?>
			
						<div class="content_product" style="width: 1045px;">
							<div class="list_product">
								<div id="attribute_product">
									<table align="center">
										<tr>
											<td width=230px> Modello </td>
											<td width=230px> Marca </td>
											<td width=120px> Quantita </td>
											<td width=120px> Prezzo </td>
											<td width=120px> Ricarico </td>
											<td width=225px> Univoco </td>						
										<tr>	
									</table>
								</div>
								<div id="view_product" style="max-height: 350px;">

							<?php

							OpenTable();

							$productsDDT = mysql_query( "Select T.Prodotto, T.Marca, T.Quantita, T.Prezzo_Acquisto, T.Ricarico, I.Univoco_Prodotto
															From Fornito as T, Identifica as I
															Where T.DDT = 
																  ( Select ID From DDT Where ID_Trasporto = $ddt AND Fornitore = $codiceFornitore )
																  AND
																  I.Univoco_Prodotto = 
																  ( Select Univoco_Prodotto From Identifica as I 
																	Where I.Prodotto = T.Prodotto and 
																		  I.Fornitore = $codiceFornitore );", ConnectDB() );

							$color = "#CFCFCF";

							while( $row = mysql_fetch_row( $productsDDT ) )
							{
								echo "<tr bgcolor=$color>";
								echo "<td width=230px> $row[0] </td>";
								echo "<td width=230px> $row[1] </td>";
								echo "<td width=120px> $row[2] </td>";
								echo "<td width=120px> $row[3] </td>";
								echo "<td width=120px> $row[4] </td>";
								echo "<td width=225px> $row[5] </td>";	
								echo "</tr>";
								$color = ( $color == "#CFCFCF" ) ? "#F3F3F3" : "#CFCFCF";
							} 

							CloseTable();

							?>

								</div>
								<div id="line_bottom" style="width: 992px;"></div>
								<div id="tools">
									<!-- VUOTA -->
								</div>
							</div>
						</div>

						<?php
					}

				?>
			</div> <!-- -->
		</div>
	</body>
</html>
