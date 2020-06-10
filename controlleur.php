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

function suiteRecherche($number){

    $dbh = connexion('pgsql:host=localhost;dbname=etudiants', 'postgres', 'isen2018');


    if($number == 1){
        <form>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="inputEmail4">Nom</label>
                    <input type="text" class="form-control" id="inputEmail4">
                </div>
                <div class="form-group col-md-6">
                    <label for="inputPassword4">Prénom</label>
                    <input type="text" class="form-control" id="inputPassword4">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="inputEmail4">Email</label>
                    <input type="email" class="form-control" id="inputEmail4">
                </div>
                <div class="form-group col-md-6">
                    <label for="inputPassword4">Password</label>
                    <input type="password" class="form-control" id="inputPassword4">
                </div>
            </div>
            <div class="form-group">
                <label for="inputAddress">Address</label>
                <input type="text" class="form-control" id="inputAddress" placeholder="1234 Main St">
            </div>
            <div class="form-group">
                <label for="inputAddress2">Address 2</label>
                <input type="text" class="form-control" id="inputAddress2" placeholder="Apartment, studio, or floor">
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                <label for="inputCity">City</label>
                <input type="text" class="form-control" id="inputCity">
                </div>
                <div class="form-group col-md-4">
                <label for="inputState">State</label>
                <select id="inputState" class="form-control">
                    <option selected>Choose...</option>
                    <option>...</option>
                </select>
                </div>
                <div class="form-group col-md-2">
                <label for="inputZip">Zip</label>
                <input type="text" class="form-control" id="inputZip">
                </div>
            </div>
            <div class="form-group">
                <div class="form-check">
                <input class="form-check-input" type="checkbox" id="gridCheck">
                <label class="form-check-label" for="gridCheck">
                    Check me out
                </label>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Sign in</button>
        </form>
    }

    if($number == 2){
        
    }

    if($number == 3){
        
    }

    if($number == 4){
        
    }

    if($number == 5){
        
    }

    if($number == 6){
        
    }

    if($number == 7){
        
    }

    if($number == 8){
        
    }

    if($number == 9){
        
    }


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