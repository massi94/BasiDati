<!DOCTYPE html>
<html>
	<head>
		<style>
			@import url( 'style.css' );
		</style>
	</head>
	<body>

		<div class="window">

			<div id="signin">
				<div id="title"> Accesso </div>
				<div id="forms">
					<form method="POST" action="login.php">
						<div id="codice">
							<div class="label"> Codice: </div>
							<div class="form"> <input type="text" name="Codice"> </div>
						</div>
						<div id="tessera">
							<div class="label"> Tessera: </div>
							<div class="form"> <input type="text" name="Tessera"> </div>
						</div>	

						<?php

							if( isset( $_GET["Error"] ) )
							{
								?>
								<div id="errore">
									Errore, nessun utente trovato
								</div>
								<?php
							}
						?>

						<div id="submit">
							<div id="button"> <input type="submit" value="Accedi"> </div>
						</div>	
					</form>	
				</div>
			</div>

		</div>

	</body>
</html>
