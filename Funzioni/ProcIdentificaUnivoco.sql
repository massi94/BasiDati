DELIMITER |
DROP PROCEDURE IF EXISTS IdentificaUnivoco|
CREATE PROCEDURE IdentificaUnivoco (Prodotto VARCHAR(20), Fornitore INTEGER, Univoco INTEGER)
BEGIN
IF NOT EXISTS(SELECT I.Prodotto, I.Fornitore FROM Identifica AS I WHERE I.Prodotto=Prodotto and I.Fornitore=Fornitore)
THEN
INSERT INTO Identifica (Prodotto, Fornitore, Univoco_Prodotto) VALUES (Prodotto, Fornitore, Univoco);
END IF;
END |
DELIMITER ;




