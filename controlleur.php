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
    for($i=1;$i<=$_SESSION['nbPass'];$i++){
        $query = "INSERT INTO customer VALUES(DEFAULT,?,?,?,?)";
        $insert = $bdd->prepare($query);
        $insert->execute([$_GET['nom'.$i],$_GET['prenom'.$i],$_GET['date'.$i],$_GET['mail'.$i]]);
        $_SESSION['passager'.$i] = array($_GET['nom'.$i],$_GET['prenom'.$i],$_GET['date'.$i],$_GET['mail'.$i]);
    }
}

function getInfoVol(){
    $tab = array($_SESSION['nbPass'],$_SESSION['depart'],$_SESSION['cityDep'],$_SESSION['arrive'],$_SESSION['cityArr'],$_SESSION['dateVol']);
    $json = json_encode($tab);
    echo $json;
}

function infoConfirmation(){

    /*$qry = "SELECT nom,prenom,age INTO Passager WHERE idReservation=?";
    $slct = $bdd->prepare($qry);
    $slct->execute([$_SESSION["idCommande"]]);

    $passagers = $slct->fetchAll();

    $qry2 = "SELECT INTO Fly WHERE ID=?";
    $slct2 = $bdd->prepare($qry2);
    $slct2->execute([$passagers[0]["ID_FLY"]]);
    $vol = $slct2->fetch();


    $data = array(array($_SESSION["nbPass"],$_SESSION["id_Vol"],$_SESSION["cityDep"],$_SESSION["cityArr"],$_SESSION["heureDep"],$vol["dateToDeparture"],$_SESSION["prix"]),$passagers);

    $json = json_encode($data);
    echo $json;*/

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