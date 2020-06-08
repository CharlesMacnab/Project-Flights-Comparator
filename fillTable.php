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
exec("C:/Users/ychar/AppData/Local/Programs/Python/Python38/python.exe table.py");
$dsn = 'mysql:host=localhost;port=3306;dbname=projetCIR2';
$user = 'admin';
$password = 'password';
$bdd = connexpdo($dsn,$user,$password);

$fli = 'flights.csv';
$fli = read($fli);
for($i=1;$i<count($fli);$i++){
    $query = "INSERT INTO vols VALUES(?,?,?,?,?,?,?,?,?,?,?)";
    $insert = $bdd->prepare($query);
    $insert->execute([$fli[$i][0],$fli[$i][1],$fli[$i][2],$fli[$i][3],$fli[$i][4],$fli[$i][7],$fli[$i][8],$fli[$i][11],$fli[$i][12],$fli[$i][13],$fli[$i][14]]);
}

$fares = 'fares.csv';
$fares = read($fares);
for($i=1;$i<count($fares);$i++){
    $query1 = "INSERT INTO billets VALUES(?,?,?,?,?,?)";
    $insert1 = $bdd->prepare($query1);
    $insert1->execute([$fares[$i][0],$fares[$i][2],$fares[$i][3],$fares[$i][4],$fares[$i][5],$fares[$i][1]]);
}

$taxes = 'airportsurcharges.csv';
$taxes = read($taxes);
for($i=1;$i<count($taxes);$i++){
    $query2 = "INSERT INTO taxes VALUES(?,?,?)";
    $insert2 = $bdd->prepare($query2);
    $insert2->execute([$taxes[$i][2],$taxes[$i][0],$taxes[$i][3]]);
}

?>
