DROP TRIGGER IF EXISTS ApplicaSconto;
DELIMITER |
CREATE TRIGGER ApplicaSconto
AFTER INSERT ON Movimento
FOR EACH ROW
BEGIN
CALL PuntiTessera(New.Punti, New.Tessera);
IF(New.Punti<0)
THEN
INSERT INTO Applicato (Select NEW.Acquisto, Totale From Sconto Where ABS(NEW.Punti)=Punti );
END IF;

END |
DELIMITER ;

