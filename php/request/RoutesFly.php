<?php

function dbRequestRoutes($db, $depAirport, $arrAirport, $jour){
    try {
        $request = 'SELECT ID, nbPlaces FROM vols WHERE depAirport=:depAirport AND arrAirport=:arrAirport AND jour=:jour';
        $statement = $db->prepare($request);
        $statement->bindParam(':depAirport', $depAirport, PDO::PARAM_STR_CHAR);
        $statement->bindParam(':arrAirport', $arrAirport, PDO::PARAM_STR_CHAR);
        $statement->bindParam(':jour', $jour, PDO::PARAM_INT);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);
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
        $result = $statement->fetch(PDO::FETCH_ASSOC);
    }

    catch (PDOException $exception) {
        error_log('Request error: '.$exception->getMessage());
        return false;
    }
    return $result;
}

?>
