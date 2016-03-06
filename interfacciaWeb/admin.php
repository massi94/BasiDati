<!DOCTYPE html>
<html>
	<head>
		<style>
			@import url( 'style.css' )
		</style>
	</head>
	<?php
		require( 'utility.php' );
	?>
	<body>
		<div class="window">

			<div class="top_bar">
				<div style="margin-top: 5px; margin-left: 20px;">
					<div id="benvenuto">
						Benvenuto, Amministratore
					</div>
				</div>
			</div>

			<div id="view_user">
				<div id="switch">
					<table>
						<tr>
							<td> 
								<a href="acquisti_admin.php" target="info"> 
									<input type="submit" value="Acquisti">
								</a> 
							</td>
							<td> 
								<a href="movimento_admin.php" target="info"> 
									<input type="submit" value="Movimento Punti"> 
								</a> 
							</td>
							<td> 
								<a href="aggiunta_utente.php" target="info"> 
									<input type="submit" value="Aggiungi cliente">
								</a> 
							</td>
							<td> 
								<a href="rimuovi_tessera" target="info"> 
									<input type="submit" value="Rimuovi tessera"> 
								</a> 
							</td>
							<td> 
								<a href="modifica_utente" target="info"> 
									<input type="submit" value="Modifica cliente"> 
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
