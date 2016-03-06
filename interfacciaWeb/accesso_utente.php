<!DOCTYPE html>
<html>
	<head>
		<style>
			@import url( 'style.css' )
		</style>
	</head>
	<?php
		require( 'utility.php' );

		$user = $_GET["Utente"];

		$ris_infoUser = mysql_query( "SELECT Nome, Cognome, Punti 
									  FROM Cliente_Registrato C JOIN Tessera T ON C.Codice_Fiscale = T.Cliente_Registrato 
									  WHERE C.Codice_Fiscale = '$user';", ConnectDB() );

		$row_infoUser = mysql_fetch_row( $ris_infoUser );
	?>
	<body>
		<div class="window">

			<div class="top_bar">
				<div style="margin-top: 5px; margin-left: 20px;">
					<div id="benvenuto">
						<?php echo "Benvenuto, $row_infoUser[0] $row_infoUser[1]"; ?>
					</div>
					<div id="punteggio">
						Hai accumulato fino ad ora: <?php echo $row_infoUser[2] ?> punti
					</div>
				</div>
			</div>

			<div id="view_user">
				<div id="switch">
					<table>
						<tr>
							<td> 
								<a href="acquisti.php?Utente=<?php echo $user; ?>" target="info"> 
									<input type="submit" value="Acquisti">
								</a> 
							</td>
							<td> 
								<a href="movimento.php?Utente=<?php echo $user; ?>" target="info"> 
									<input type="submit" value="Movimento Punti"> 
								</a> 
							</td>
						</tr>
					</table>
				</div>
				<div id="content">
					<iframe frameborder=0 
							marginheight=0 
							marginwidth=0 
							width="1075px"
							height="500px"
		            		name='info'>
					</iframe>
				</div>
			</div>

		</div>
	</body>
</html>
