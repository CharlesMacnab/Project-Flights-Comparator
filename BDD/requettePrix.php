<?php

require_once('constants.php');

//dbRequestTarif(dbConnect(),"CA2",21,60,0);
dbRequestTaxe(dbConnect(),"YAM",4);


function dbConnect()
{
    try
    {
        $db = new PDO('mysql:host='.DB_SERVER.';dbname='.DB_NAME.';charset=utf8',
            DB_USER, DB_PASSWORD);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch (PDOException $exception)
    {
        error_log('Connection error: '.$exception->getMessage());
        return false;
    }
    return $db;
}


function dbRequestTarif($bdd,$idRoad,$dayBeforeFly,$filling,$weFlights)
{

    try
    {
        $sth = $bdd->prepare('SELECT idFares FROM faresOfRoad WHERE idRoad =?');
        $sth->execute([$idRoad]);
        $result = $sth->fetchAll();
        $sth->closeCursor(PDO::FETCH_ASSOC);

        $min=-1;

        foreach ($result as $value) {
            $sth = $bdd->prepare('SELECT fareCode FROM fares WHERE idFares =? AND weFlights=?');
            $sth->execute([$value[0],$weFlights]);
            $fareCode = $sth->fetch();

            $sth = $bdd->prepare('SELECT * FROM faresCode WHERE fareCode =? AND dateToDeparture<? AND fillingRate>?');
            $sth->execute([$fareCode[0],$dayBeforeFly,$filling]);


            if($sth->rowCount() != 0){

                $sth = $bdd->prepare('SELECT fare FROM fares WHERE idFares =?');
                $sth->execute([$value[0]]);
                $fare = $sth->fetch();

                if($min==-1) {
                    $min=$fare["fare"];
                }

                else if($min>$fare["fare"]){
                    $min=$fare["fare"];
                }
            }

            $sth->closeCursor(PDO::FETCH_ASSOC);
        }
        return $min;
    }
    catch (PDOException $exception)
    {
        error_log('Request error: '.$exception->getMessage());
        return false;
    }

}


function dbRequestTaxe($bdd,$airportCode,$age)
{
    try
    {
        $sth = $bdd->prepare('SELECT surcharge FROM airportSurchanges WHERE airportCode =?');
        $sth->execute([$airportCode]);
        $result = $sth->fetch();
        $sth->closeCursor(PDO::FETCH_ASSOC);

        if ($age<=1461) {
            $result[0]/=2;
        }

        return $result[0];
    }
    catch (PDOException $exception)
    {
        error_log('Request error: '.$exception->getMessage());
        return false;
    }
}


?>




