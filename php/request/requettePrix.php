<?php


function dbRequestTarif($bdd,$route,$day,$filling)
{

    $dayBeforeFly=$day-date(dn);
    try
    {
        $sth = $bdd->prepare('SELECT fare FROM fares WHERE route =? AND dataTodepartyre>? AND filliginrate<?');
        $sth->execute([$route,$dayBeforeFly,$filling]);
        $result = $sth->fetchAll();
        $sth->closeCursor(PDO::FETCH_ASSOC);
    }
    catch (PDOException $exception)
    {
        error_log('Request error: '.$exception->getMessage());
        return false;
    }

    $min=$result[0];
    foreach ($result as $value) {
        if ($value<$min) {
           $min=$value;
        }
    }
    return $min;
}


function dbRequestTaxe($bdd,$airportCode,$age)
{
    try
    {
        $sth = $bdd->prepare('SELECT  FROM surchange WHERE airportCode =?');
        $sth->execute([$airportCode,$age]);
        $result = $sth->fetchAll();
        $sth->closeCursor(PDO::FETCH_ASSOC);
    }
    catch (PDOException $exception)
    {
        error_log('Request error: '.$exception->getMessage());
        return false;
    }

    foreach ($result as $value) {
        if ($age>4) {
            $value/=2;
        }
    }

    return $result;
}


?>