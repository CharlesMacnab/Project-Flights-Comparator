CREATE TABLE AirportSurchanges(
                                  airportCode Varchar (50) NOT NULL ,
                                  city        Varchar (50) NOT NULL ,
                                  state       Varchar (50) NOT NULL ,
                                  latitude    INT NOT NULL,
                                  logitude    INT NOT NULL,
                                  surcharge   Int NOT NULL
    ,CONSTRAINT AirportSurchanges_PK PRIMARY KEY (airportCode)
);

CREATE TABLE Fights(
                       id_Vol                        Int  Auto_increment  NOT NULL ,
                       route                         Varchar (50) NOT NULL ,
                       distanceKm                    Int NOT NULL ,
                       dayOfWeek                     Int NOT NULL ,
                       departureTime                 Time NOT NULL ,
                       arrivalTime                   time NOT NULL ,
                       flightSize                    Int NOT NULL ,
                       airportCode                   Varchar (50) NOT NULL ,
                       airportCode_AirportSurchanges Varchar (50) NOT NULL
    ,CONSTRAINT Fights_PK PRIMARY KEY (id_Vol)

    ,CONSTRAINT Fights_AirportSurchanges_FK FOREIGN KEY (airportCode) REFERENCES AirportSurchanges(airportCode)
    ,CONSTRAINT Fights_AirportSurchanges0_FK FOREIGN KEY (airportCode_AirportSurchanges) REFERENCES AirportSurchanges(airportCode)
);

CREATE TABLE Fares(
                      id              VARCHAR(50) NOT NULL ,
                      route           Varchar (50) NOT NULL ,
                      weFlights       Int NOT NULL ,
                      fareCode        Varchar (50) NOT NULL ,
                      dateToDeparture Int NOT NULL ,
                      fillingRate     Int NOT NULL ,
                      fare            Int NOT NULL
    ,CONSTRAINT Fares_PK PRIMARY KEY (id)
);

CREATE TABLE Fly(
                    ID              Int  Auto_increment  NOT NULL ,
                    filling         Int NOT NULL ,
                    dateToDeparture Date NOT NULL ,
                    id_Vol          Int NOT NULL
    ,CONSTRAINT Fly_PK PRIMARY KEY (ID)

    ,CONSTRAINT Fly_Fights_FK FOREIGN KEY (id_Vol) REFERENCES Fights(id_Vol)
);

CREATE TABLE Passager(
                         id              Int  Auto_increment  NOT NULL ,
                         Prix            Float NOT NULL ,
                         nom             Varchar (50) NOT NULL ,
                         prenom          Varchar (50) NOT NULL ,
                         age             Varchar (50) NOT NULL ,
                         tel             Varchar (50) NOT NULL ,
                         mail            Varchar (50) NOT NULL ,
                         DateReservation Date NOT NULL ,
                         ID_Fly          Int NOT NULL
    ,CONSTRAINT Passager_PK PRIMARY KEY (id)

    ,CONSTRAINT Passager_Fly_FK FOREIGN KEY (ID_Fly) REFERENCES Fly(ID)
);