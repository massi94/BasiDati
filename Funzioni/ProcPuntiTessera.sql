DROP Procedure IF EXISTS PuntiTessera;
DELIMITER $$
CREATE Procedure PuntiTessera(PuntiMovim INTEGER, TesseraMovim INTEGER) 
BEGIN
UPDATE Tessera SET Punti=Punti+PuntiMovim WHERE Numero=TesseraMovim;
END$$
DELIMITER ;

