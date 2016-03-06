<?php
	function AddInputLabel( $label, $input )
	{
		return "<div class='input_text'>
					<div id='label'> $label </div>
					<div id='form'> $input </div>
				</div>";
	}

    function ConnectDB()
	{
		global $connect;

		if( isset( $connect ) ) return $connect;
		else 
		{
			$connect = mysql_connect( 
						"basidati1004.studenti.math.unipd.it:3306",
						"fmassign",
						"EK141K2E" )
						or die( $_SERVER['PHP_SELF'] . "connessione fallita!" );

			mysql_select_db( 'fmassign-PR', $connect );

			return $connect;
		}
	}
	
    /*====== Gestione tabelle ======*/
    function AddRow( $attribute )
    {
        echo "<tr>";
        
        foreach( $attribute as $col )
        {   
            echo "<td> $col </td>";
        }
        
        echo "</tr>";
    }

    function OpenTable()
    {
        echo "<table width=100%>";
    }


    function CloseTable()
    {
        echo "</table>";
    }
    /*===============================*/

	function exactlyMatch( $regex, $text )
	{
		$risp = preg_match( $regex, $text, $matches, PREG_OFFSET_CAPTURE );
		
		if( $risp !== 1 ){ return false; }
		else
		{
			$sizeMatch = strlen( $matches[0][0] );
			$offsetMatch = $matches[0][1];

			if( $sizeMatch < strlen( $text ) || $offsetMatch > 0 ){ return false; }
			else{ return true; }
		}	
	}


	function PrintError( $error )
	{
		echo "<div id='errore' class='error'> $error </div>";
	}
?>
