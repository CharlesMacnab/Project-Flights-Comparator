<?php

function connexpdo($database,$user,$password){
    try {
        return new PDO($database,$user,$password);
    } catch (PDOException $e) {
        echo 'Connexion échouée : ' . $e->getMessage();
    }
}

function read($csv){
    $file = fopen($csv, 'r');
    while (!feof($file) ) {
        $line[] = fgetcsv($file, 1024);
    }
    fclose($file);
    return $line;
}

function insertFly($bdd,$flight,$compt){
    $jour = getdate();
    $date = new DateTime($jour['year'].'-'.$jour['mon'].'-'.$jour['mday']);
    $qry1 = "INSERT INTO Fly VALUES (DEFAULT,0,?,?)";
    $insrt1 = $bdd->prepare($qry1);
    if($flight[11]%7 == $jour['wday']){
        $nbJour = 7 * $compt;
        $date->add(new DateInterval("P".$nbJour."D"));
        $insrt1->execute([date_format($date,'Y-m-d'),$flight[0]]);
    }
    else if($flight[11]%7 == ($jour['wday']+1)%7){
        $nbJour = 7 * $compt + 1;
        $date->add(new DateInterval("P".$nbJour."D"));
        $insrt1->execute([date_format($date,'Y-m-d'),$flight[0]]);
    }
    else if($flight[11]%7 == ($jour['wday']+2)%7){
        $nbJour = 7 * $compt + 2;
        $date->add(new DateInterval("P".$nbJour."D"));
        $insrt1->execute([date_format($date,'Y-m-d'),$flight[0]]);
    }
    else if($flight[11]%7 == ($jour['wday']+3)%7){
        $nbJour = 7 * $compt + 3;
        $date->add(new DateInterval("P".$nbJour."D"));
        $insrt1->execute([date_format($date,'Y-m-d'),$flight[0]]);
    }
    else if($flight[11]%7 == ($jour['wday']+4)%7){
        $nbJour = 7 * $compt + 4;
        $date->add(new DateInterval("P".$nbJour."D"));
        $insrt1->execute([date_format($date,'Y-m-d'),$flight[0]]);
    }
    else if($flight[11]%7 == ($jour['wday']+5)%7){
        $nbJour = 7 * $compt + 5;
        $date->add(new DateInterval("P".$nbJour."D"));
        $insrt1->execute([date_format($date,'Y-m-d'),$flight[0]]);
    }
    else if($flight[11]%7 == ($jour['wday']+6)%7){
        $nbJour = 7 * $compt + 6;
        $date->add(new DateInterval("P".$nbJour."D"));
        $insrt1->execute([date_format($date,'Y-m-d'),$flight[0]]);
    }
}

function fill($bdd){
    $taxes = 'airportsurcharges2.csv';
    $taxes = read($taxes);
    for($i=1;$i<count($taxes);$i++){
        $query2 = "INSERT INTO AirportSurchanges VALUES(?,?,?,0,0,?)";
        $insert2 = $bdd->prepare($query2);
        $insert2->execute([$taxes[$i][2],$taxes[$i][0],$taxes[$i][1],$taxes[$i][3]]);
    }

    $fares = 'fares2.csv';
    $fares = read($fares);
    for($i=1;$i<count($fares);$i++){
        $query1 = "INSERT INTO Fares VALUES(DEFAULT,?,?,?,?,?,?)";
        $insert1 = $bdd->prepare($query1);
        $insert1->execute([$fares[$i][0],$fares[$i][2],$fares[$i][3],$fares[$i][4],$fares[$i][5],$fares[$i][1]]);
    }

    $fli = 'flights2.csv';
    $fli = read($fli);
    for($i=1;$i<count($fli);$i++){
        $search = "SELECT * FROM AirportSurchanges WHERE airportCode=?";
        $src = $bdd->prepare($search);
        $src->execute([$fli[$i][3]]);
        if($src->rowCount() == 0){
            $qry = "INSERT INTO AirportSurchanges VALUES (?,?,'UNKNOWN',?,?,0)";
            $insrt = $bdd->prepare($qry);
            $insrt->execute([$fli[$i][3],$fli[$i][4],$fli[$i][5],$fli[$i][6]]);
        }
        else {
            $qry = "UPDATE AirportSurchanges SET latitude = $fli[$i][5], longitude = $fli[$i][6] WHERE airportCode=?";
            $update = $bdd->prepare($qry);
            $update->execute([$fli[$i][3]]);
        }
    }

    for($i=1;$i<count($fli);$i++){
        $query = "INSERT INTO Fights VALUES(?,?,?,?,?,?,?,?,?)";
        $insert = $bdd->prepare($query);
        $insert->execute([$fli[$i][0],$fli[$i][1],$fli[$i][2],$fli[$i][11],$fli[$i][12],$fli[$i][13],$fli[$i][14],$fli[$i][3],$fli[$i][7]]);
        for($j=0;$j<4;$j++){
            insertFly($bdd,$fli[$i],$j);
        }
    }
}
exec("python table.py");

$dsn = 'mysql:host=localhost;port=3306;dbname=projetCIR2';
$user = 'admin';
$password = 'password';
$bdd = connexpdo($dsn,$user,$password);

fill($bdd);

?>
