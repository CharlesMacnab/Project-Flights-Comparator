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

function infoVol(){
    if(isset($_POST["depart"],$_POST["arrive"],$_POST["date"],$_POST["passager"])){
        $_SESSION["airportD"] = $_POST["depart"];
        $_SESSION["airportA"] = $_POST["arrive"];
        $_SESSION["dateVol"] = $_POST["date"];
        $_SESSION["nbPass"] = $_POST["passager"];
    }
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


    $data = array($array($_SESSION["nbPass"],$_SESSION["id_Vol"],$_SESSION["villeDep"],$_SESSION["villeArr"],$_SESSION["heureDep"],$vol["dateToDeparture"],$_SESSION["prix"]),$passagers)
    
    $json = json_encode($data);
    echo $json;

}

if($_GET["func"]=="infoConfirmation"){
    infoConfirmation($bdd);
}
if($_GET["func"]=="infoVol"){
    infoVol();
}

?>