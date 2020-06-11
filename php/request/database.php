<?php

require_once('../constants.php');

//----------------------------------------------------------------------------
//--- dbConnect --------------------------------------------------------------
//----------------------------------------------------------------------------
// Create the connection to the database.
// \return False on error and the database otherwise.
function dbConnect() {
    try {
        $db = new PDO('mysql:host='.DB_SERVER.';dbname='.DB_NAME.';charset=utf8', DB_USER, DB_PASSWORD);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    catch (PDOException $exception) {
        echo 'Connexion échouée : ' . $exception->getMessage();
        error_log('Connection error: '.$exception->getMessage());
        return false;
    }
    return $db;
}


//ID, route, distance, depAirport, depVille, arrAirport, arrVille, jour, depHeure, arrHeure, nbPlaces
function dbRequestRoutes($db, $depAirport, $arrAirport, $jour){
    try {
        $request = 'SELECT ID, nbPlaces FROM vols WHERE depAirport=:depAirport AND arrAirport=:arrAirport AND jour=:jour';
        $statement = $db->prepare($request);
        $statement->bindParam(':depAirport', $depAirport, PDO::PARAM_STR_CHAR);
        $statement->bindParam(':arrAirport', $arrAirport, PDO::PARAM_STR_CHAR);
        $statement->bindParam(':jour', $jour, PDO::PARAM_INT);
        $statement->execute();
        $result = $statement->fetchall(PDO::FETCH_ASSOC);
    }
    catch (PDOException $exception) {
        error_log('Request error: '.$exception->getMessage());
        return false;
    }
    return $result;
}

function dbRequestFly($db, $id_vol, $nbPlacesMax){
    try {
        $request = 'SELECT filling, dateToDeparture FROM fly WHERE id_Vol=:id_Vol AND filling<:filling';
        $statement = $db->prepare($request);
        $statement->bindParam(':id_Vol', $id_vol, PDO::PARAM_INT);
        $statement->bindParam(':filling', $nbPlacesMax, PDO::PARAM_INT);
        $statement->execute();
        $result = $statement->fetchall(PDO::FETCH_ASSOC);
    }
    catch (PDOException $exception) {
        error_log('Request error: '.$exception->getMessage());
        return false;
    }
    return $result;
}

function dbRequestVilles($db){
    try {
        $request = 'SELECT airportCode, city FROM airportsurchanges';
        $statement = $db->prepare($request);
        $statement->execute();
        $result = $statement->fetchall(PDO::FETCH_ASSOC);
    }
    catch (PDOException $exception) {
        error_log('Request error: '.$exception->getMessage());
        return false;
    }
    return $result;
}


?>
