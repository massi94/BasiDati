<!DOCTYPE html>
<html>
	<head>
		<style>
			@import url( 'style.css' )
		</style>
	</head>
	<?php
		require( 'utility.php' );
		require( 'setting.php' );

		$dataStart = ( isset( $_GET["DataStart"] ) && exactlyMatch( $_REG_DATA, $_GET["DataStart"] ) ) ? $_GET["DataStart"] : "";
		$dataEnd = ( isset( $_GET["DataEnd"] ) && exactlyMatch( $_REG_DATA, $_GET["DataEnd"] ) ) ? $_GET["DataEnd"] : "";
		$sottocategoria = ( isset( $_GET["SottoCategoria"] ) ) ? $_GET["SottoCategoria"] : "Tutte";
	?>
	<body>	
		<div class="window">
			<div class="top_bar">
				<form method="GET">
					<div class="sequence_forms">
						<div class="input_label">
							<div id="label"> Data: </div>
							<div id="form"> 
								dal <input type="text" name="DataStart" size=4 value="<?php echo $dataStart; ?>">
								al <input type="text" name="DataEnd" size=4 value="<?php echo $dataEnd ?>"> 
							</div>
						</div>
						<div class="input_label">
							<div id="label"> Sotto Categoria: </div>
							<div id="form"> 
								<select name="SottoCategoria">
									<?php
									
										$category = mysql_query( "SELECT Nome FROM Categoria", ConnectDB() );

										echo "<option value='Tutte'> Tutte </option>";

										while( $nameCategory = mysql_fetch_row( $category ) )
										{
											echo "<optgroup label='$nameCategory[0]'>";

											$subCategory = mysql_query( "SELECT Id, Nome FROM Sotto_Categoria WHERE Categoria = '$nameCategory[0]';", ConnectDB() );
						
											while( $rowSubCategory = mysql_fetch_row( $subCategory ) )
											{
												echo "<option value='$rowSubCategory[0]' ";
												if( $rowSubCategory[0] == $sottocategoria ) echo "selected ";
												echo "> $rowSubCategory[1] </option>";
											} 
						
											echo "</optgroup>";
										}
									
									?>
								</select>
							</div>
						</div>
						<div id="submit"> <input type="submit" name="Invio" value="Cerca"> </div>
					</div>
				</form>			
			</div>

			<div style="width: 100%;">
				<div class="list_product" style="margin-top: 20px;">
					<div id="attribute_product">
						<table align="center">
							<tr>
								<td width=150px> Sotto Categoria </td>
								<td width=150px> Prezzo </td>
								<td width=105px> Quantita </td>
							<tr>
						</table>
					</div>
					<div id="view_product" style="height: 350px;">

					<?php
						OpenTable();

						$condition = "";	
						$condition_data = "";		

						if( $sottocategoria != "Tutte" || $dataStart != "" || $dataEnd != "" )
						{
							$condition = "WHERE TRUE";

							if( $sottocategoria != "Tutte" ) $condition .= " AND SC.Id = $sottocategoria ";
						
							if( $dataStart != "" ) { $condition_data .= " AND DATE( Ac.Data ) >= DATE( '$dataStart' ) "; }
							if( $dataEnd != "" ) { $condition_data .= " AND DATE( Ac.Data ) <= DATE( '$dataEnd' ) "; }

							$condition .= $condition_data;
						}


						$ris_resoconto = mysql_query( "Select SC.Nome as SottoCategoria, COALESCE(SUM(Prezzo_Vendita),0) as Prezzo, COALESCE(SUM(Quantita),0) as Quantita
													   From 
														 (( Sotto_Categoria SC LEFT JOIN Appartiene A ON SC.Id=A.Sotto_Categoria )
														 LEFT JOIN Riguarda R ON A.Prodotto=R.Prodotto) LEFT JOIN Acquisto Ac ON R.Acquisto=Ac.Id
														 $condition
													   Group By SC.Nome;", ConnectDB() ) or die( " 1 " . mysql_error() );

						$color = "#CFCFCF";

						while( $row = mysql_fetch_row( $ris_resoconto ) )
						{
							echo "<tr bgcolor=$color>";
							echo "<td width=150px> $row[0] </td>";
							echo "<td width=150px> $row[1] </td>";
							echo "<td width=105px> $row[2] </td>";
							echo "</tr>";
							$color = ( $color == "#CFCFCF" ) ? "#F3F3F3" : "#CFCFCF";
						} 

						CloseTable();
					?>

					</div>
					<div id="line_bottom" style="width: 1045px;"></div>
				</div>
			</div>

			<div style="width: 100%; margin-top: 20px;">
				<div class="list_product">
					<div id="attribute_product">
						<table align="center">
							<tr>
								<td width=78px></td>
								<td width=155px> Numero </td>
								<td width=260px> Lordo </td>
								<td width=260px> Imponibile </td>
								<td width=105px> IVA </td>
							<tr>
						</table>
					</div>
					<div id="view_product" style="height: 50px;">

					<?php
						OpenTable();

						$ris_ammontare = mysql_query( "select 
															Ric.Tipo,
															Count(Ric.Tipo), 
															Sum( Ac.Somma) as Lordo, 
															ROUND( Sum(Ac.Imponibile), 2 ) as Imp, 
															ROUND( Sum(Ac.Somma)-Sum(Ac.Imponibile), 2 )  as IVA
													   from 
															Ricevuta Ric, 
															( select 
																 A.Id,
																 A.Data, 
																 Sum(R.Prezzo_Vendita) as Somma, Sum(R.Prezzo_Vendita/((P.IVA/100)+1)) as Imponibile 
															  from 
																( Acquisto A JOIN Riguarda R ON A.Id=R.Acquisto ) 
																JOIN Prodotto P ON R.Prodotto=P.Modello group by A.Id 
															) Ac
														where Ric.Acquisto=Ac.Id $condition_data
														group by Ric.Tipo;", ConnectDB() ) or die( " 1 " . mysql_error() );

						$color = "#CFCFCF";

						$accumulatore = array(
											"Numero" => 0,
											"Lordo" => 0,
											"Imponibile" => 0,
											"IVA" => 0
										);

						while( $row = mysql_fetch_row( $ris_ammontare ) )
						{
							echo "<tr bgcolor=$color>";
							echo "<td bgcolor='white' width=70px>". ( ( $row[0] == 'F' ) ? "Fattura" : "Scontrino" ) . "</td>";
							echo "<td width=155px> $row[1] </td>";
							echo "<td width=260px> $row[2] </td>";
							echo "<td width=260px> $row[3] </td>";
							echo "<td width=105px> $row[4] </td>";
							echo "</tr>";

							$accumulatore["Numero"] += $row[1];
							$accumulatore["Lordo"] += $row[2];
							$accumulatore["Imponibile"] += $row[3];
							$accumulatore["IVA"] += $row[4];

							$color = ( $color == "#CFCFCF" ) ? "#F3F3F3" : "#CFCFCF";
						} 

						CloseTable();
					?>

					</div>
					<div id="line_bottom" style="width: 1045px;"></div>	
					<div style="width: 1045px">
						<table align="center" style="margin-left: 20px;">
							<tr>
								<td width=95px> Totale </td>
								<td width=185px> <?php echo $accumulatore["Numero"]; ?> </td>
								<td width=310px> <?php echo $accumulatore["Lordo"]; ?> </td>
								<td width=310px> <?php echo $accumulatore["Imponibile"]; ?> </td>
								<td> <?php echo $accumulatore["IVA"]; ?> </td>
							</tr>
						</table>
					</div>
				</div>
			</div>
		
		</div>
	</body>
</html>
