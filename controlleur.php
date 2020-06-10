<?php

session_start();

if($_GET['func'] == 'suiteRecherche'){
    suiteRecherche($_POST['number']);
}

function connexion($base, $user, $password){

    try {
        $dbh = new PDO($base, $user, $password);
    } catch (PDOException $e) {
        echo 'Connexion échouée : ' . $e->getMessage();
    }
    return $dbh;

}

function infoVol($bdd){
    $_SESSION["airDep"] = $_GET["depAir"];
    $_SESSION["airArr"] = $_GET["arrAir"];
    $_SESSION["dateVol"] = $_GET["date"];
    $_SESSION["nbPass"] = $_GET["nbPass"];

    $qry = "SELECT FROM AirportSurchanges WHERE airportCode=?";

    $slct = $bdd->prepare($qry);
    $slct->execute([$_SESSION["airDep"]]);
    $rst = $slct->fetch();
    $_SESSION["cityDep"] = $rst["city"];
    
    $slct2 = $bdd->prepare($qry);
    $slct2->execute([$_SESSION["airArr"]]);
    $rst2 = $slct2->fetch();
    $_SESSION["cityArr"] = $rst2["city"];
}

function infoPassager(){

}

function getInfoVol(){
    $json = json_encode([$_SESSION["nbPass"],$_SESSION["depArr"],$_SESSION["cityDep"],$_SESSION["airArr"],$_SESSION["cityArr"],$_SESSION["dateVol"]]);
    echo $json;
}

function infoConfirmation($bdd){
    
    $qry = "SELECT nom,prenom,age INTO Passager WHERE idReservation=?";
    $slct = $bdd->prepare($qry);
    $slct->execute([$_SESSION["idCommande"]]);
    
    $passagers = $slct->fetchAll();
    
    $qry2 = "SELECT INTO Fly WHERE ID=?";
    $slct2 = $bdd->prepare($qry2);
    $slct2->execute([$passagers[0]["ID_FLY"]]);
    $vol = $slct2->fetch();


    $data = array(array($_SESSION["nbPass"],$_SESSION["id_Vol"],$_SESSION["cityDep"],$_SESSION["cityArr"],$_SESSION["heureDep"],$vol["dateToDeparture"],$_SESSION["prix"]),$passagers);
    
    $json = json_encode($data);
    echo $json;

}

if($_GET["func"]=="infoConfirmation"){
    //infoConfirmation();
}
if($_GET["func"]=="infoVol"){
    infoVol($bdd);
}
if($_GET["func"]=="getInfoVol"){
    getInfoVol();
}



?>