DROP TABLE IF EXISTS Cliente_Registrato;
DROP TABLE IF EXISTS Residenza;
DROP TABLE IF EXISTS Tessera;
DROP TABLE IF EXISTS Acquisto;
DROP TABLE IF EXISTS Movimento;
DROP TABLE IF EXISTS Applicato;
DROP TABLE IF EXISTS Sconto;
DROP TABLE IF EXISTS Ricevuta;
DROP TABLE IF EXISTS Prodotto;
DROP TABLE IF EXISTS Appartiene;
DROP TABLE IF EXISTS Riguarda;
DROP TABLE IF EXISTS DDT;
DROP TABLE IF EXISTS Fornito;
DROP TABLE IF EXISTS Fornitore;
DROP TABLE IF EXISTS Identifica;
DROP TABLE IF EXISTS Anagrafica;
DROP TABLE IF EXISTS Categoria;
DROP TABLE IF EXISTS Sotto_Categoria;
CREATE TABLE Cliente_Registrato
(
	Codice_Fiscale CHARACTER(16) PRIMARY KEY,
	Nome VARCHAR(20),
	Cognome VARCHAR(20),
	Nascita DATE,
	P_IVA VARCHAR(10),
	Residenza INTEGER,
	Telefono INTEGER,
	FOREIGN KEY( Residenza ) REFERENCES Residenza( ID ) 
)engine=innoDB;
CREATE TABLE Residenza
(
	Id INTEGER PRIMARY KEY,
	Citta VARCHAR(20),
	Via VARCHAR(20),
	N_Civico INTEGER
)engine=innoDB;
CREATE TABLE Tessera
(
	Numero INTEGER PRIMARY KEY,
	Cliente_Registrato VARCHAR(20),
	PUNTI INTEGER,
	FOREIGN KEY( Cliente_Registrato ) REFERENCES Cliente_Registrato( Codice_Fiscale )
)engine=innoDB;
CREATE TABLE Acquisto
(
	Id INTEGER AUTO_INCREMENT PRIMARY KEY,
	Data DATETIME,
	Cliente_Registrato VARCHAR(20),
	FOREIGN KEY( Cliente_Registrato ) REFERENCES Cliente_Registrato( Codice_Fiscale )
)engine=innoDB;
CREATE TABLE Movimento
(
	Acquisto INTEGER PRIMARY KEY,
	Tessera INTEGER,
	Punti INTEGER,
	FOREIGN KEY( Acquisto ) REFERENCES Acquisto(Id),
	FOREIGN KEY( Tessera ) REFERENCES Tessera( Numero ) ON DELETE CASCADE
)engine=innoDB;
CREATE TABLE Applicato
(
	Acquisto INTEGER PRIMARY KEY,
	Sconto INTEGER REFERENCES Sconto( Totale ),
	FOREIGN KEY( Acquisto ) REFERENCES Acquisto( Id )
)engine=innoDB;
CREATE TABLE Sconto
(
	Punti INTEGER PRIMARY KEY,
	Totale INTEGER NOT NULL UNIQUE
)engine=innoDB;
CREATE TABLE Ricevuta
(
	Acquisto INTEGER PRIMARY KEY,
	Tipo CHARACTER,
	Numero INTEGER,
	FOREIGN KEY( Acquisto ) REFERENCES Acquisto( Id )
)engine=innoDB;
CREATE TABLE Prodotto
(
        Modello VARCHAR(20) PRIMARY KEY,
	Marca VARCHAR(20),
        Prezzo_Vendita DECIMAL(5,2),
        Ricarico INTEGER, 
        Giacenza INTEGER,
	IVA INTEGER default 0
)engine=innoDB;
CREATE TABLE Appartiene
(
	Prodotto VARCHAR(20),
	Sotto_Categoria INTEGER(20),
	PRIMARY KEY(Prodotto),
	FOREIGN KEY(Sotto_Categoria ) REFERENCES Sotto_Categoria(Id),
	FOREIGN KEY(Prodotto) REFERENCES Prodotto(Modello)
)engine=innoDB;
CREATE TABLE Riguarda
(
	Acquisto INTEGER,
	Prodotto VARCHAR(20),
	Quantita INTEGER,
	Prezzo_Vendita DECIMAL(5,2),
	PRIMARY KEY(Acquisto, Prodotto),
	FOREIGN KEY(Acquisto ) REFERENCES Acquisto(Id),
	FOREIGN KEY(Prodotto ) REFERENCES Prodotto(Modello)
)engine=innoDB;
CREATE TABLE DDT
(
	Id INTEGER AUTO_INCREMENT PRIMARY KEY,
        ID_Trasporto INTEGER,
        Data DATETIME default NOW(),
	Fornitore INTEGER
)engine=innoDB;
CREATE TABLE Fornito
(
        DDT INTEGER,
	Prodotto VARCHAR(20),
	Marca VARCHAR(20),
        Quantita INTEGER,
	Prezzo_Acquisto DECIMAL(8,2),
	Ricarico INTEGER,
        PRIMARY KEY( DDT, Prodotto ),
        FOREIGN KEY( DDT ) REFERENCES DDT( Id ),
	FOREIGN KEY( Prodotto ) REFERENCES Prodotto( Modello )
)engine=innoDB;
CREATE TABLE Fornitore
(
        Codice INTEGER PRIMARY KEY,
        Ragione_Sociale VARCHAR(20)
)engine=innoDB;
CREATE TABLE Identifica
(
        Prodotto VARCHAR(20),
        Fornitore INTEGER,
        Univoco_Prodotto INTEGER,
        PRIMARY KEY( Fornitore, Prodotto ),
        FOREIGN KEY( Prodotto ) REFERENCES Prodotto( Modello ),
        FOREIGN KEY( Fornitore ) REFERENCES Fornitore( Codice )
)engine=innoDB;
CREATE TABLE Anagrafica
(
	Fornitore INTEGER PRIMARY KEY,
	P_IVA INTEGER,
	Indirizzo VARCHAR(20),
        Telefono VARCHAR(20),
	FOREIGN KEY(Fornitore) REFERENCES Fornitore(Codice)
)engine=innoDB;
CREATE TABLE Categoria
(
        Nome VARCHAR(20) PRIMARY KEY
)engine=innoDB;

CREATE TABLE Sotto_Categoria
(
	Id INTEGER AUTO_INCREMENT PRIMARY KEY,
	Categoria VARCHAR(20),
	Nome VARCHAR(20),
	FOREIGN KEY(Categoria) REFERENCES Categoria(Nome)
)engine=innoDB;
