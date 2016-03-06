DROP TRIGGER IF EXISTS AddProdotto;
DELIMITER |
CREATE TRIGGER AddProdotto
BEFORE INSERT ON Fornito
FOR EACH ROW
BEGIN
IF EXISTS(SELECT P.Modello FROM Prodotto AS P WHERE P.Modello=New.Prodotto)
THEN
If((SELECT P.Ricarico FROM Prodotto AS P WHERE P.Modello=NEW.Prodotto)<New.Ricarico)
THEN
	UPDATE Prodotto 
	SET Prezzo_Vendita=NEW.Prezzo_Acquisto*(1+(NEW.Ricarico/100)),
	Ricarico=NEW.Ricarico
	WHERE Modello=New.Prodotto;
END IF;

UPDATE Prodotto 
SET Giacenza=Giacenza+New.Quantita
WHERE Modello=New.Prodotto;

ELSE
INSERT INTO Prodotto(Modello,Marca,Prezzo_Vendita,Ricarico,Giacenza)
	VALUES(
	New.Prodotto,
	New.Marca,
	New.Prezzo_Acquisto*(1+(New.Ricarico/100)),
	New.Ricarico,
	New.Quantita);
END IF;
END |
DELIMITER ;

