<!doctype html>
<html>
    <head>
        <title> Prova </title>
        <style> @import url( 'style.css' ); </style>
    </head>
    <?php
        require( 'setting.php' );
    ?>
    <body>
        <div class='main'> <!-- Riquadro principale -->
            <div class='intestazione'>
                Titolo
            </div>
            <div class='left'> <!-- Colonna sinistra, menu selezione pagina -->
	           <div class='lnk_maschera'>
                   
                       <ul>
				<li> 
					<a href="prodotti.php? <?php echo "Categoria=$_CATEGORY_ALL& SottoCategoria=$_SUB_CATEGORY_NULL" ?>" target="finestra"> 
						Prodotti 
					</a>
					<ul>
						<li> 
							<a href="ddt.php" target="finestra">
								DDT
							</a> 
						</li>
					</ul>
				</li>
				
			</ul>
                   
	           </div>
	           <div class='lnk_maschera'>
					<a href="utente.php" target="finestra"> 
						Utente
					</a>     
	           </div>
	           <div class='lnk_maschera'> 
			Gestione Fiscale	               
	           </div>
				<div class='lnk_maschera'> 
					<a href="vendite.php" target="finestra"> 
						Vendite
					</a>               
	           </div>
            </div>
	    <div class="frame"> <!-- Colonna destra, finestra sulle pagine esterne -->
			<iframe frameborder=0 
					marginheight=0 
					marginwidth=0 
					width="1098px"
					height="652px"
					src='accesso_utente.php'
		            name='finestra'>
			</iframe>
	    </div>
	</div>
    </body>
</html>
