<?php

session_start();



function connexion($base, $user, $password){

    try {
        $dbh = new PDO($base, $user, $password);
    } catch (PDOException $e) {
        echo 'Connexion échouée : ' . $e->getMessage();
    }
    return $dbh;

}

$bdd = connexion('mysql:host=localhost;port=3306;dbname=projetCIR2','admin','password');

function infoVol($bdd){

    $_SESSION['depart'] = $_GET['depAir'];
    $_SESSION['arrive'] = $_GET['arrAir'];
    $_SESSION['dateVol'] = $_GET['date'];
    $_SESSION['nbPass'] = $_GET['nbPass'];

    $qry = "SELECT city FROM AirportSurchanges WHERE airportCode=?";

    $slct = $bdd->prepare($qry);
    $slct->execute([$_GET['depAir']]);
    $rst = $slct->fetch();
    $_SESSION['cityDep'] = $rst['city'];

    $slct2 = $bdd->prepare($qry);
    $slct2->execute([$_SESSION['arrive']]);
    $rst2 = $slct2->fetch();
    $_SESSION['cityArr'] = $rst2['city'];

    $tab = array($_SESSION['nbPass'],$_SESSION['depart'],$_SESSION['cityDep'],$_SESSION['arrive'],$_SESSION['cityArr'],$_SESSION['dateVol']);
    $json = json_encode($tab);
    echo $json;
}

function infoPassager($bdd){
    $query = "INSERT INTO customer VALUES(DEFAULT,?,?,?,?)";
    $insert = $bdd->prepare($query);
    $pas = explode(' ',$_GET['passenger']);
    $id = $pas[0];
    $insert->execute([$pas[1],$pas[2],$pas[3],$pas[4]]);
    $_SESSION["passager".$id] = array($pas[1],$pas[2],$pas[3],$pas[4],0);
   
}

function getInfoVol(){
    $tab = array($_SESSION['nbPass'],$_SESSION['depart'],$_SESSION['cityDep'],$_SESSION['arrive'],$_SESSION['cityArr'],$_SESSION['dateVol']);
    $json = json_encode($tab);
    echo $json;
}



function infoConfirmation(){

    $passagers = array();
    for($i=1;$i<=$_SESSION["nbPass"];$i++){
        $passagers.push($_SESSION["passager".$i]);
    }


    $data = array(array($_SESSION["nbPass"],$_SESSION["id_Vol"],$_SESSION["depart"],$_SESSION["cityDep"],$_SESSION["arrive"],$_SESSION["cityArr"],$_SESSION["dateToDeparture"],$_SESSION["heureDep"],$_SESSION["heureArr"]),$passagers);

    $json = json_encode($data);
    echo $json;

}

include "php/request/RoutesFly.php";
include "php/request/requettePrix.php";

function prixBillet($bdd,$fly,$road){

    // Calcul places remplies
    $filling = $fly["filling"]/$road["flightSize"]*100;
    $prixTotal = 0;
    
    $prixVol = dbRequestTarif($bdd,$road["id_Vol"],$fly["dateToDeparture"],$filling);
    for($i=1;$i<=$_SESSION["nbPass"];$i++){
        // Calcul âge
        $date1 = new DateTime("now");
        $date2 = new DateTime($_SESSION["passager".$i][3]);
        $datediff = $date1->diff($date2);
        $age = (int)$datediff->format("%Y");
        $prixTaxe = dbRequestTaxe($bdd,$road["airportCode"],$age) + dbRequestTaxe($bdd,$road["airportCode_Arr"],$age);
        $_SESSION["passager".$i][5] = $prixVol + $prixTaxe;
        $prixTotal += $prixTaxe + $prixVol; 
    }
    $_SESSION["prixTotal"] = $prixTotal;
    return $prixTotal;
    
}

function infoSearch($bdd){

    //Les vols disponibles
    $jour = date("N", strtotime($_SESSION["dateVol"]));
    $tab = dbRequestRoutes($bdd, $_SESSION["depart"]$_SESSION["arrive"],$jour);
    $nbSearch = 0;
    $tab2 = array();
    foreach ($tab as $flight){
        $flys = dbRequestFly($bdd,$flight["id_vol"],$flight["flightSize"]);
        $nbSearch += count($flys);
        foreach($tab2 as $fly){
            $prixTotal = prixBillet($bdd,$fly,$flight);
            $vol = array($fly["id_Fly"],$flight["id_Vol"],$fly["dateToDeparture"],$flight["heureDep"],$flight["heureArr"],$prixTotal);
            $tab2.push($vol);
        }
    }
        
    $json = json_encode(array($nbSearch,$tab2);
    echo $json;



    
}

function reservation($bdd){
    $idFly = $_GET["id"];

    $qry = "SELECT FROM Fly WHERE idFly = ?";
    $sl = $bdd->prepare($qry);
    $sl->execute([$idFly]);
    $fly = $sl->fetch();

    $qry2 = "SELECT FROM road WHERE id_Vol = ?";
    $sl2 = $bdd->prepare($qry2);
    $sl2->execute([$fly["id_Vol"]]);
    $road = $sl2->fetch();

    $_SESSION["id_Vol"] = $road["id_Vol"];
    $_SESSION["heureDep"] = $road["heureDep"];
    $_SESSION["heureArr"] = $road["heureArr"];
    $_SESSION["dateToDeparture"] = $fly["dateToDeparture"];

    $idBook = substr($_SESSION["passager1"][1],0,3).substr($_SESSION["passager1"][2],0,3).strval($_SESSION["prixTotal"]);

    for($i=1;$i<=$_SESSION["nbPass"],$i++){
        $qry3 = "SELECT FROM customers WHERE mailAddress=?"
        $sl3 = $bdd->prepare($qry3);
        $sl3->execute([$_SESSION["passager".$i][4]])
        $customer = $sl3->fetch();

        $qry4 = "INSERT INTO passenger VALUES (DEFAULT,?,CURRENT_DATE,?,$customer["idCustomer"])"
        $in = $bdd->prepare($qry4);
        $in->execute([$_SESSION["passager".$i][5],$idBook])
    }
}

if($_GET["func"]=="getSearch"){
    getSearch();
}

if($_GET["func"]=="infoConfirmation"){
    infoConfirmation();
}
if($_GET["func"]=="infoVol"){
    infoVol($bdd);
}
if($_GET["func"]=="getInfoVol"){
    getInfoVol();
}
if($_GET["func"]=="setPassenger"){
    infoPassager($bdd);
}
if($_GET["func"]=="reservation"){
    reservation($bdd);
}



?>