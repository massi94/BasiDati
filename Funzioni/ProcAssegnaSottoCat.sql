DELIMITER |
DROP PROCEDURE IF EXISTS AssegnaSottoCat|
CREATE PROCEDURE AssegnaSottoCat (Modello VARCHAR(20), SottoCat INTEGER)
BEGIN
IF NOT EXISTS(SELECT Ap.Prodotto FROM Appartiene AS Ap WHERE Ap.Prodotto=Modello)
THEN
	INSERT INTO Appartiene (Prodotto, Sotto_Categoria) VALUES (Modello, SottoCat);
END IF;
END |
DELIMITER ;
