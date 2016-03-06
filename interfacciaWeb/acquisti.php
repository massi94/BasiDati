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

		$user = $_GET["Utente"];	
	?>
	<body>	
		<div class="top_bar">
			<form method="GET" action="acquisti.php" >
				<input type="hidden" name="Utente" value="<?php echo $user; ?>">
				<div class="sequence_forms">
					<div class="input_label">
						<div id="label"> Data: </div>
						<div id="form"> <input type="text" name="DataStart" size=4> - <input type="text" name="DataEnd" size=4> </div>
					</div>
					<div class="input_label">
						<div id="label"> Prezzo: </div>
						<div id="form"> 
							<input type="text" name="PrezzoStart" size=2> - <input type="text" name="PrezzoEnd" size=2>  
							<select name="PrezzoOrder">
								<option value="ASC"> Crescente </option>
								<option value="DESC"> Decrescente </option>
							</select>
						</div>
					</div>
					<div id="submit"> <input type="submit" name="Invio" value="Cerca"> </div>
				</div>
			</form>			
		</div>

		<div style="width: 100%; margin-top: 10px;">
			<div class="list_product">
				<div id="attribute_product">
					<table align="center">
						<tr>
							<td width=150px> Modello </td>
							<td width=150px> Marca </td>
							<td width=105px> Quantita </td>
							<td width=105px> Prezzo </td>
							<td width=150px> Data </td>		
						<tr>
					</table>
				</div>
				<div id="view_product" style="height: 400px;">

				<?php
					OpenTable();

					mysql_query( "Create or replace view AcquistiCliente as	select * From Acquisto where Cliente_Registrato='$user';", ConnectDB() );
					mysql_query( "Create or replace view ProdottiAcquisto as 
								  Select R.Prodotto, R.Quantita, R.Prezzo_Vendita, A.Data 
								  From AcquistiCliente A, Riguarda R 
								  Where A.Id=R.Acquisto;", ConnectDB() );

					$condition = "";
					
					$prezzoStart = ( isset( $_GET["PrezzoStart"] ) && exactlyMatch( $_REG_NUMERO, $_GET["PrezzoStart"] ) ) ? $_GET["PrezzoStart"] : "";
					$prezzoEnd = ( isset( $_GET["PrezzoEnd"] ) && exactlyMatch( $_REG_NUMERO, $_GET["PrezzoEnd"] ) ) ? $_GET["PrezzoEnd"] : "";
					$dataStart = ( isset( $_GET["DataStart"] ) && exactlyMatch( $_REG_DATA, $_GET["DataStart"] ) ) ? $_GET["DataStart"] : "";
					$dataEnd = ( isset( $_GET["DataEnd"] ) && exactlyMatch( $_REG_DATA, $_GET["DataEnd"] ) ) ? $_GET["DataEnd"] : "";

					if( $prezzoStart != "" ) $condition = "AND PA.Prezzo_Vendita >= $prezzoStart ";
					if( $prezzoEnd != "" ) $condition .= "AND PA.Prezzo_Vendita <= $prezzoEnd ";

					if( $dataStart != "" ) $condition .= "AND PA.Data >= STR_TO_DATE( '$dataStart', '%Y-%m-%d' ) ";
					if( $dataEnd != "" ) $condition .= "AND PA.Data <= STR_TO_DATE( '$dataEnd', '%Y-%m-%d' ) ";

					$condition .= "ORDER BY ";

					if( isset( $_GET["PrezzoOrder"] ) )
					{
						$order = $_GET["PrezzoOrder"];
						$condition .= "PA.Prezzo_Vendita $order, ";
					}

					$condition .= "PA.DATA ASC";
					
					$ris_acquisti = mysql_query( "Select PA.Prodotto, P.Marca, PA.Quantita, PA.Prezzo_Vendita, PA.Data 
												  From Prodotto P, ProdottiAcquisto PA 
												  Where PA.Prodotto=P.Modello
												  $condition;", ConnectDB() );

					$color = "#CFCFCF";

					while( $row = mysql_fetch_row( $ris_acquisti ) )
					{
						echo "<tr bgcolor=$color>";
						echo "<td width=150px> $row[0] </td>";
						echo "<td width=150px> $row[1] </td>";
						echo "<td width=105px> $row[2] </td>";
						echo "<td width=105px> $row[3] </td>";
						echo "<td width=150px> $row[4] </td>";
						echo "</tr>";
						$color = ( $color == "#CFCFCF" ) ? "#F3F3F3" : "#CFCFCF";
					} 

					mysql_query( "drop view if exists AcquistiCliente;", ConnectDB() );
					mysql_query( "drop view if exists Prodotti;", ConnectDB() );

					CloseTable();
				?>

				</div>
				<div id="line_bottom" style="width: 1022px;"></div>
			</div>
		</div>
		

	</body>
</html>
