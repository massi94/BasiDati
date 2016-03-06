<!DOCTYPE html>
<html>
	<head>
		<style>
			@import url( 'style.css' );
		</style>
	</head>
	<?php
		require( 'setting.php' );
		require( 'utility.php' );
	?>
	<body>

		<div class="window">
			<table style="width: 1050px; margin-left: 20px; margin-top: 20px; margin-bottom: 40px;">
				<tr>
					<td> Clienti che hanno acquistato un prodotto una volta sola, e il relativo prodotto: </td>
				</tr>
				<tr>
					<td>

						<div style="width: 100%;">
							<div class="list_product">
								<div id="attribute_product">
									<table align="center">
										<tr>
											<td width="200px"> Codice Fiscale </td>
											<td width="150px"> Nome </td>
											<td width="200px"> Cognome </td>
											<td> Prodotto </td>
										<tr>
									</table>
								</div>
								<div id="view_product" style="height: 200px;">
									<?php
										OpenTable();
								
										$ris_uniqueProdotto = mysql_query( "(Select C.Codice_Fiscale, C.Nome, C.Cognome, R.Prodotto
																			From Cliente_Registrato C, Acquisto A, Riguarda R
																			Where C.Codice_Fiscale=A.Cliente_Registrato AND 
																				  A.Id=R.Acquisto AND C.Codice_Fiscale<>'0' AND 
																				  NOT EXISTS ( 
																				  	select A1.Id, A1.Cliente_Registrato, R1.Prodotto
																					from Acquisto A1, Riguarda R1
																					where A1.Id=R1.Acquisto AND A1.Cliente_Registrato=A.Cliente_Registrato AND
																						  A1.Id<>A.Id AND R.Prodotto=R1.Prodotto
																			 	  ) );", ConnectDB() );
	
										$color = "#CFCFCF";

										while( $row = mysql_fetch_row( $ris_uniqueProdotto ) )
										{
											echo "<tr bgcolor=$color>";
											echo "<td width='200px'> $row[0] </td>";
											echo "<td width='150px'> $row[1] </td>";
											echo "<td width='200px'> $row[2] </td>";
											echo "<td> $row[3] </td>";
											echo "</tr>";
		
											$color = ( $color == "#CFCFCF" ) ? "#F3F3F3" : "#CFCFCF";
										}

										CloseTable();
									?>
								</div>
							<div id="line_bottom" style="width: 987px;"></div>
						</div>

					</td>
				</tr>
			</table>	
	

			<table style="width: 1050px; margin-left: 20px; margin-top: 20px; margin-bottom: 40px;">
				<tr>
					<td> Le cinque sottocategorie piu' vendute nello scorso mese che continuano ad esserlo nel mese corrente: </td>
				</tr>
				<tr>
					<td>

						<div style="width: 100%;">
							<div class="list_product">
								<div id="attribute_product">
									<table align="center">
										<tr>
											<td width="200px"> Sotto Categoria </td>
										<tr>
									</table>
								</div>
								<div id="view_product" style="height: 200px;">
									<?php
										OpenTable();
								
										$ris_bestCategoria = mysql_query( "select PASS.Nome
																		   FROM(
																				select SC.Nome, SUM(R.Quantita) as Massimo
																				from Sotto_Categoria SC, Appartiene A, Riguarda R, Acquisto Acq
																				where SC.Id=A.Sotto_Categoria AND 
																				 	  A.Prodotto=R.Prodotto AND 
																				 	  Acq.Id=R.Acquisto AND
																				 	  MONTH(Acq.Data)=MONTH(NOW())
																				Group by SC.Nome
																				Order By Massimo DESC
																				LIMIT 5
																		    ) CORR INNER JOIN (
																				select SC1.Nome, SUM(R1.Quantita) as Massimo
																				from Sotto_Categoria SC1, Appartiene A1, Riguarda R1, Acquisto Acq1
																				where SC1.Id=A1.Sotto_Categoria AND 
																			 		  A1.Prodotto=R1.Prodotto AND 
																			 		  Acq1.Id=R1.Acquisto AND
																			 		  MONTH(Acq1.Data)= MONTH(NOW())-1
																				 Group by SC1.Nome
																				 Order By Massimo DESC
																				 LIMIT 5 
																			) PASS ON CORR.Nome=PASS.Nome;", ConnectDB() );
	
										$color = "#CFCFCF";

										while( $row = mysql_fetch_row( $ris_bestCategoria ) )
										{
											echo "<tr bgcolor=$color>";
											echo "<td width='200px'> $row[0] </td>";
											echo "</tr>";
		
											$color = ( $color == "#CFCFCF" ) ? "#F3F3F3" : "#CFCFCF";
										}

										CloseTable();
									?>
								</div>
							<div id="line_bottom" style="width: 987px;"></div>
						</div>

					</td>
				</tr>
			</table>


			<table style="width: 1050px; margin-left: 20px; margin-top: 20px; margin-bottom: 40px;">
				<tr>
					<td> Clienti che hanno acquistato almeno un prodotto in ogni categoria: </td>
				</tr>
				<tr>
					<td>

						<div style="width: 100%;">
							<div class="list_product">
								<div id="attribute_product">
									<table align="center">
										<tr>
											<td width="200px"> Codice Fiscale </td>
											<td width="150px"> Nome </td>
											<td width="200px"> Cognome </td>
										<tr>
									</table>
								</div>
								<div id="view_product" style="height: 200px;">
									<?php
										OpenTable();
								
										$ris_uniqueProdotto = mysql_query( "SELECT R.Codice_Fiscale, R.Nome, R.Cognome
																			FROM Cliente_Registrato R 
																			WHERE NOT EXISTS(
																				SELECT Nome 
																				FROM Categoria
																				WHERE Categoria.Nome NOT IN(
																					SELECT SC1.Categoria
																					FROM Acquisto A1, Riguarda R1, Appartiene App1, Sotto_Categoria SC1
																					WHERE A1.Cliente_Registrato = R.Codice_Fiscale AND
																						  A1.Id = R1.Acquisto AND
																						  R1.Prodotto = App1.Prodotto AND
																						  App1.Sotto_Categoria = SC1.Id 
																					)
																			);", ConnectDB() );
	
										$color = "#CFCFCF";

										while( $row = mysql_fetch_row( $ris_uniqueProdotto ) )
										{
											echo "<tr bgcolor=$color>";
											echo "<td width='200px'> $row[0] </td>";
											echo "<td width='150px'> $row[1] </td>";
											echo "<td width='200px'> $row[2] </td>";
											echo "</tr>";
		
											$color = ( $color == "#CFCFCF" ) ? "#F3F3F3" : "#CFCFCF";
										}

										CloseTable();
									?>
								</div>
							<div id="line_bottom" style="width: 987px;"></div>
						</div>

					</td>
				</tr>
			</table>

			<table style="width: 1050px; margin-left: 20px; margin-top: 20px; margin-bottom: 40px;">
				<tr>
					<td> Clienti che hanno effettuato piu' acquisti con gli sconti: </td>
				</tr>
				<tr>
					<td>

						<div style="width: 100%;">
							<div class="list_product">
								<div id="attribute_product">
									<table align="center">
										<tr>
											<td width="260px"> Codice Fiscale </td>
											<td width="210px"> Nome </td>
											<td width="260px"> Cognome </td>
											<td> Numero Acquisti </td>
										<tr>
									</table>
								</div>
								<div id="view_product" style="height: 200px;">
									<?php
										OpenTable();
								
										mysql_query( "create view AcquistiScontatiPerCliente AS
													  select A.Cliente_Registrato, count(*) as NumAcquisti
													  from Acquisto A Right JOIN Applicato Ap ON A.Id=Ap.Acquisto
												      where A.Cliente_Registrato<>'0'
													  Group By A.Cliente_Registrato;", ConnectDB() );


										$ris_clientiSconti = mysql_query( "Select C.Codice_Fiscale, C.Nome, C.Cognome, Acq.NumAcquisti
																		   	from AcquistiScontatiPerCliente Acq, Cliente_Registrato C
																			Where Acq.Cliente_Registrato=C.Codice_Fiscale AND
																				  Acq.NumAcquisti >= ALL( 
																					Select Acq1.NumAcquisti 
																					From AcquistiScontatiPerCliente Acq1
																				  );", ConnectDB() );
	
										$color = "#CFCFCF";

										while( $row = mysql_fetch_row( $ris_clientiSconti ) )
										{
											echo "<tr bgcolor=$color>";
											echo "<td width='260px'> $row[0] </td>";
											echo "<td width='210px'> $row[1] </td>";
											echo "<td width='260px'> $row[2] </td>";
											echo "<td> $row[3] </td>";
											echo "</tr>";
		
											$color = ( $color == "#CFCFCF" ) ? "#F3F3F3" : "#CFCFCF";
										}

										mysql_query( "DROP VIEW IF EXISTS AcquistiScontatiPerCliente;", ConnectDB() );
																					
										CloseTable();
									?>
								</div>
							<div id="line_bottom" style="width: 987px;"></div>
						</div>

					</td>
				</tr>
			</table>


		</div>
	</body>
</html>
