DROP PROCEDURE IF EXISTS AddPunti;
DELIMITER $$
CREATE PROCEDURE AddPunti(Cliente Varchar(20), Acquisto Integer, PuntiScalati INTEGER)
BEGIN
Declare NumTessera INTEGER;
Declare Totale INTEGER;
Declare PuntiPresenti INTEGER;

select T.Punti into PuntiPresenti
from Tessera T
where T.Cliente_Registrato=Cliente;

IF EXISTS(SELECT T.Cliente_Registrato FROM Tessera as T WHERE Cliente=T.Cliente_Registrato)
THEN
Select T.Numero INTO NumTessera From Tessera as T WHERE Cliente=T.Cliente_Registrato;
IF(PuntiScalati=0 OR PuntiPresenti<(PuntiScalati*-1))
THEN
Select TRUNCATE(TotaleAcquisto(Acquisto)/10,0) into Totale;
INSERT INTO Movimento VALUES (Acquisto, NumTessera, Totale);
ELSEIF(PuntiScalati<0)
THEN
INSERT INTO Movimento VALUES (Acquisto, NumTessera, PuntiScalati);
END IF;
END IF;

END$$
DELIMITER ;



