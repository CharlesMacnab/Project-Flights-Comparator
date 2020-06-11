#------------------------------------------------------------
#        Script MySQL.
#------------------------------------------------------------


#------------------------------------------------------------
# Table: airportSurchanges
#------------------------------------------------------------

CREATE TABLE airportSurchanges(
        airportCode Varchar (50) NOT NULL ,
        city        Varchar (200) NOT NULL ,
        state       Varchar (200) NOT NULL ,
        longitude   Double NOT NULL ,
        latitude    Double NOT NULL ,
        surcharge   Float NOT NULL
	,CONSTRAINT airportSurchanges_PK PRIMARY KEY (airportCode)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: road
#------------------------------------------------------------

CREATE TABLE road(
        idRoad                        Varchar (50) NOT NULL ,
        flightDistance                Float NOT NULL ,
        dayOfWeek                     Int NOT NULL ,
        departureTime                 Time NOT NULL ,
        arrivalTime                   Time NOT NULL ,
        flightSize                    Int NOT NULL ,
        airportCode                   Varchar (50) NOT NULL ,
        airportCode_airportSurchanges Varchar (50) NOT NULL
	,CONSTRAINT road_PK PRIMARY KEY (idRoad)

	,CONSTRAINT road_airportSurchanges_FK FOREIGN KEY (airportCode) REFERENCES airportSurchanges(airportCode)
	,CONSTRAINT road_airportSurchanges0_FK FOREIGN KEY (airportCode_airportSurchanges) REFERENCES airportSurchanges(airportCode)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: flight
#------------------------------------------------------------

CREATE TABLE flight(
        idFlight        Int  Auto_increment  NOT NULL ,
        filling         Int NOT NULL ,
        dateToDeparture Date NOT NULL ,
        idRoad          Varchar (50) NOT NULL
	,CONSTRAINT flight_PK PRIMARY KEY (idFlight)

	,CONSTRAINT flight_road_FK FOREIGN KEY (idRoad) REFERENCES road(idRoad)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: customer
#------------------------------------------------------------

CREATE TABLE customer(
        idCustomer  Int  Auto_increment  NOT NULL ,
        lastName    Varchar (100) NOT NULL ,
        fristName   Varchar (200) NOT NULL ,
        dateOfBirth Date NOT NULL ,
        mailAddress Varchar (200) NOT NULL
	,CONSTRAINT customer_PK PRIMARY KEY (idCustomer)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table:  passenger
#------------------------------------------------------------

CREATE TABLE passenger(
        idPassenger   Int  Auto_increment  NOT NULL ,
        ticketPrice   Float NOT NULL ,
        dateOfBooking Date NOT NULL ,
        idBooking     Varchar (50) NOT NULL ,
        idFlight      Int NOT NULL ,
        idCustomer    Int NOT NULL
	,CONSTRAINT passenger_PK PRIMARY KEY (idPassenger)

	,CONSTRAINT passenger_flight_FK FOREIGN KEY (idFlight) REFERENCES flight(idFlight)
	,CONSTRAINT passenger_customer0_FK FOREIGN KEY (idCustomer) REFERENCES customer(idCustomer)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: faresCode
#------------------------------------------------------------

CREATE TABLE faresCode(
        fareCode        Char (5) NOT NULL ,
        dateToDeparture Int NOT NULL ,
        fillingRate     Float NOT NULL
	,CONSTRAINT faresCode_PK PRIMARY KEY (fareCode)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: fares
#------------------------------------------------------------

CREATE TABLE fares(
        idFares   Int  Auto_increment  NOT NULL ,
        weFlights Int NOT NULL ,
        fare      Float NOT NULL ,
        fareCode  Char (5) NOT NULL
	,CONSTRAINT fares_PK PRIMARY KEY (idFares)

	,CONSTRAINT fares_faresCode_FK FOREIGN KEY (fareCode) REFERENCES faresCode(fareCode)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: faresOfRoad
#------------------------------------------------------------

CREATE TABLE faresOfRoad(
        idRoad  Varchar (50) NOT NULL ,
        idFares Int NOT NULL
	,CONSTRAINT faresOfRoad_PK PRIMARY KEY (idRoad,idFares)

	,CONSTRAINT faresOfRoad_road_FK FOREIGN KEY (idRoad) REFERENCES road(idRoad)
	,CONSTRAINT faresOfRoad_fares0_FK FOREIGN KEY (idFares) REFERENCES fares(idFares)
)ENGINE=InnoDB;

