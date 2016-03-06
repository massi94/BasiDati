DELIMITER |
DROP FUNCTION IF EXISTS ModelloUnivoco|
CREATE FUNCTION ModelloUnivoco (Codice VARCHAR(20)) RETURNS VARCHAR(20)
BEGIN
DECLARE Risultato VARCHAR(20);
IF EXISTS (SELECT Modello FROM Prodotto WHERE Codice=Modello)
THEN
	SELECT Modello INTO Risultato FROM Prodotto WHERE Modello=Codice;
ELSEIF EXISTS (SELECT Prodotto FROM Identifica WHERE Univoco_Prodotto=Codice)
THEN
	SELECT Prodotto INTO Risultato FROM Identifica WHERE Univoco_Prodotto=Codice LIMIT 1;
ELSE set Risultato=NULL;
END IF;
Return Risultato;
END |
DELIMITER ;
