<?php
	$_CATEGORY_ALL = "Tutti";

	$_ERROR = true;
	$_ERROR_GET = "&Error=$_ERROR";

	$_NO_ERROR = false;
	$_SUB_CATEGORY_NULL = "Nessuna";

	$_REG_NAME = "/([A-Z]([a-z]{1,}|['])([ ']{0,1})[ ]{0,1}){1,}/";
	$_REG_DATA = "/[0-9]{4}-[0-9]{2}-[0-9]{2}/";
	$_REG_CODICE = "/[A-Z0-9]{1,}/";
	$_REG_TELEFONO = "/(\+[0-9]{1,}([ ]{0,1})){0,1}[0-9]{1,}/";
	$_REG_NUMERO = "/[0-9]{1,}/";
	$_REG_PREZZO = "/($_REG_NUMERO)\.($_REG_NUMERO)/";

	global $_CATEGORY_ALL;
	global $_ERROR;
	global $_NO_ERROR;    
	global $_SUB_CATEGORY_NULL;
	global $_REG_NAME;
	global $_REG_DATA;
	global $_REG_CODICE;
	global $_REG_TELEFONO;
	global $_REG_NUMERO;
	global $_REG_PREZZO;
?>
