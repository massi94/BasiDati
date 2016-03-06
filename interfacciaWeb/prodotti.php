<!doctype html>
<html>
	<head>
		<style>
			@import url( 'style.css' )
		</style>
	</head>
	
	<?php
		require( 'utility.php' );
        require( 'setting.php' );

        $cur_category = ( isset( $_GET["Categoria"] ) ) ? $_GET["Categoria"] : $_CATEGORY_ALL;
        $cur_subcategory = ( isset( $_GET["SottoCategoria"] ) ) ? 
                                $_GET["SottoCategoria"] : $_SUB_CATEGORY_NULL;
	?> 
	
	<body>
		<div class="window">
            <form>
                <div id="search">
                    <div id="path_category">
                        Categoria:
                        <?php
                                $path = $cur_category;

                                if( $cur_subcategory != $_SUB_CATEGORY_NULL )
                                {
                                    echo $path . " > " . $cur_subcategory;
                                }
                                else echo $path;
                        ?> 
                    </div>
                    <div class="search_product">
                        <div id="by_model">
                            <div class="input_text">
                                <div id="label">
                                    Modello:
                                </div>
                                <div id="form">
                                    <input type="text" size="15">
                                </div>
                            </div>
                        </div>
                        <div id="by_supplier">
                            <div id="supplier">
                                <div class="input_text">
                                    <div id="label">
                                        Fornitori:
                                    </div>
                                    <div id="form">
                                        <fieldset style="border-width: 0px; padding: 0;">
                                            <select>
                                                <?php
													$fornitore = mysql_query( "SELECT Ragione_Sociale FROM Fornitore;", ConnectDB() );
													
													while( $row = mysql_fetch_row( $fornitore ) )
													{
														echo "<option> $row[0] </option>";
													} 
												?>
                                            </select>
                                        </fieldset>
                                    </div>
                                </div>
                            </div>
                            <div id="unique">
                                <div class="input_text">
                                    <div id="label">
                                        Univoco:
                                    </div>
                                    <div id="form">
                                        <input type="text">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="send">
                            <input type="submit" value="Cerca">
                        </div>
                    </div>
                </div>    
            </form>
			<div id="list_category">
				<!--
				Menu a tendina, modello:
				<ul>
					<li> 
						Voce n
						<ul>
							<li> Sottovoce n <li>
						</ul>
					</li>		
				</ul> 
				-->
				<?php
					$menu = mysql_query( "SELECT Nome FROM Categoria", ConnectDB() );

					echo "<ul>";
					while( $categoria = mysql_fetch_row( $menu ) )
					{
						

						$subMenu = mysql_query( "SELECT Nome 
												 FROM Sotto_Categoria 
												 WHERE Categoria = '$categoria[0]'",
												ConnectDB()
											  );
						$numSubCategory = mysql_num_rows( $subMenu );				
						

                        $link = "";
                        
                        $content = ( $numSubCategory > 0 ) ? $categoria[0] . " >" : $categoria[0];
                        
						echo "<li>"; 
						echo "<a href='prodotti.php?Categoria=$categoria[0]&
                                                    SottoCategoria=$_SUB_CATEGORY_NULL'>
                                $content 
                              </a>";
                        
						if( $numSubCategory > 0 )
						{
							echo "<ul>";

							while( $sottoCategoria = mysql_fetch_row( $subMenu ) )
							{
								echo "<li> 
                                        <a href='prodotti.php?
                                                 Categoria=$categoria[0]&
                                                 SottoCategoria=$sottoCategoria[0]'> 
                                        $sottoCategoria[0] 
                                        </a> 
                                      </li>";
							}

							echo "<li></li>";
							echo "</ul>";
						}

						echo "</li>";
					} 
					echo "</ul>";
				?>
			</div>
        	<div id="view_table">
				<?php
	                $tables = mysql_query( "describe Prodotto;", ConnectDB() );

	                $attribute = array();

	                if( mysql_num_rows( $tables ) > 0 )
	                {
	                    while( $row = mysql_fetch_row( $tables ) )
	                    {
	                        array_push( $attribute, $row[0] );
	                    }
	                }

	                OpenTable();

	                AddRow( $attribute );
	                
	                AddRow( array( "PX-7589", "Mantovani", 3456, "10%", 45, "22%" ) );

	                CloseTable();
	            ?>
            </div>
		</div>
	</body>
</html>
