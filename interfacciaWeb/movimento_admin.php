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
	?>
	<body>	
		<div class="top_bar">
			<form method="GET" action="movimento_admin.php" >
				<input type="hidden" name="Utente">
				<div class="sequence_forms">
					<div class="input_label">
						<div id="label"> Data: </div>
						<div id="form"> <input type="text" name="DataStart" size=4> - <input type="text" name="DataEnd" size=4> </div>
					</div>
					<div class="input_label">
						<div id="label"> Cliente: </div>
						<div id="form"> 
							<input type="text" name="Cliente">
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
							<td width=200px> Cliente </td>
							<td width=150px> Data </td>
							<td width=150px> Punti </td>
						<tr>
					</table>
				</div>
				<div id="view_product" style="height: 400px;">

				<?php
					OpenTable();

					$condition = "";

					$cliente = "";
					if( isset( $_GET["Cliente"] ) && exactlyMatch( $_REG_CODICE, $_GET["Cliente"] ) ) { $cliente = $_GET["Cliente"]; }

					$query_cliente = ( $cliente == "" ) ? TRUE : "A.Cliente_Registrato = '$cliente'";


					$dataStart = ( isset( $_GET["DataStart"] ) && exactlyMatch( $_REG_DATA, $_GET["DataStart"] ) ) ? $_GET["DataStart"] : "";
					$dataEnd = ( isset( $_GET["DataEnd"] ) && exactlyMatch( $_REG_DATA, $_GET["DataEnd"] ) ) ? $_GET["DataEnd"] : "";

					if( $dataStart != "" ) $condition .= "AND A.Data >= STR_TO_DATE( '$dataStart', '%Y-%m-%d' ) ";
					if( $dataEnd != "" ) $condition .= "AND A.Data <= STR_TO_DATE( '$dataEnd', '%Y-%m-%d' ) ";

					$condition .= "ORDER BY A.Cliente_Registrato ASC";

					$ris_movimenti = mysql_query( "select A.Cliente_Registrato, A.Data, M.Punti 
												   from Acquisto A JOIN Movimento M ON A.Id=M.Acquisto 
												   WHERE $query_cliente $condition;", ConnectDB() );

					$color = "#CFCFCF";

					while( $row = mysql_fetch_row( $ris_movimenti ) )
					{
						echo "<tr bgcolor=$color>";
						echo "<td width=200px> $row[0] </td>";
						echo "<td width=150px> $row[1] </td>";
						echo "<td width=150px> $row[2] </td>";
						echo "</tr>";
						$color = ( $color == "#CFCFCF" ) ? "#F3F3F3" : "#CFCFCF";
					} 

					CloseTable();
				?>

				</div>
				<div id="line_bottom" style="width: 1022px;"></div>
			</div>
		</div>
		

	</body>
</html>
