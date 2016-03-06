DELIMITER |
DROP PROCEDURE IF EXISTS ProdottiAcquisto|
CREATE PROCEDURE ProdottiAcquisto (Acquisto INTEGER, Modello VARCHAR(20), AggQuantita INTEGER, Prezzo_Vendita DECIMAL(5,2))
BEGIN
DECLARE Prezzo DECIMAL(8,2);

IF((SELECT P.Giacenza FROM Prodotto as P WHERE P.Modello=Modello)>=AggQuantita)
THEN
IF (Prezzo_Vendita = 0)
THEN
set Prezzo=(SELECT P.Prezzo_Vendita FROM Prodotto as P WHERE P.Modello=Modello);
ELSE
set Prezzo=Prezzo_Vendita;
END IF;

IF EXISTS(SELECT R.Acquisto, R.Prodotto FROM Riguarda as R WHERE R.Acquisto=Acquisto and R.Prodotto=Modello)
THEN
UPDATE Riguarda as R SET R.Quantita=R.Quantita+AggQuantita, R.Prezzo_Vendita=R.Prezzo_Vendita+(Prezzo*AggQuantita) WHERE R.Acquisto=Acquisto and R.Prodotto=Modello;

ELSE
INSERT INTO Riguarda VALUES(Acquisto,Modello,AggQuantita,Prezzo*AggQuantita);
END IF;
UPDATE Prodotto as P Set Giacenza=Giacenza-AggQuantita WHERE P.Modello=Modello;
END IF;
END |
DELIMITER ;
