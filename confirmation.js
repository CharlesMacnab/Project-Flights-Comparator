function createConfirmation(data){
    let nbPass = data[0][0];
    let montantTotal = 0;
    for(let i=1; i<=nbPass;i++){
        document.getElementById("pass"+i).innerHTML = "<th scope=\"row\">"+i+"</th> <td>"+data[1][i]['nom']+"</td> <td>"+data[1][i]['prenom']+"</td> <td>"+data[1][i]['age']+"</td>"
        if(data[i][2]<4){
            document.getElementById("billet"+i).innerHTML = "Billet pour le vol "+data[0][1]+" en partance de "+data[0][2]+" vers "+data[0][3]+" le "+data[0][4]+" à "+data[0][5]+" : Prix "+data[0][6]/2+"$."
            montantTotal += data[0][6]/2;
        }
        else{
            document.getElementById("billet"+i).innerHTML = "Billet pour le vol "+data[0][1]+" en partance de "+data[0][2]+" vers "+data[0][3]+" le "+data[0][4]+" à "+data[0][5]+" : Prix "+data[0][6]+"$."
            montantTotal += data[0][6];
        }
    }
    document.getElementById("total").innerHTML = "Le montant total des "+nbPass+" billets est de : "+montantTotal+"$.";
}

ajaxRequest("GET","controlleur.php?func=infoConfirmation",createConfirmation)