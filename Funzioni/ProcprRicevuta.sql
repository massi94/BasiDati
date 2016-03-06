DROP PROCEDURE IF EXISTS prRicevuta;
DELIMITER |
CREATE PROCEDURE prRicevuta (Id_Acq INTEGER, DataRic DATETIME, Tipo CHARACTER)
BEGIN
declare NumeroRic INTEGER;
declare ultimaData DATETIME;

	select Data into ultimaData 
	from Acquisto 
	order by Data DESC LIMIT 1, 1;
	
IF (Id_Acq>1)
THEN

	IF(Tipo='F')
	THEN
		IF(YEAR(DataRic)>YEAR(ultimaData))
		THEN
			set NumeroRic=1;
		ELSE
			Select A.Massimo into NumeroRic
			From (	select MAX(Numero) as Massimo, R.Tipo, Acq.Data
				From Ricevuta R, Acquisto Acq
				Where R.Tipo='F' AND Acq.Id=R.Acquisto AND YEAR(Acq.Data)=YEAR(DataRic)) A;
			set NumeroRic=NumeroRic+1;
		END IF;
	ELSEIF(Tipo='S')
	THEN

		IF(DATE(DataRic)>DATE(ultimaData))
		THEN
			
			set NumeroRic=1;
		ELSE

			Select A.Massimo into NumeroRic
			From (	select MAX(Numero) as Massimo, R.Tipo, Acq.Data
				From Ricevuta R, Acquisto Acq
				Where R.Tipo='S' AND Acq.Id=R.Acquisto AND DATE(Acq.Data)=DATE(DataRic)) A;
			set NumeroRic=NumeroRic+1;
		END IF;
	END IF;

ELSE
	set NumeroRic=1;
END IF;
insert into Ricevuta VALUES (Id_Acq, Tipo, NumeroRic);
END |
DELIMITER ;
