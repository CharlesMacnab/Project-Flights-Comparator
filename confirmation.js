function createConfirmation(data){
    let nbPass = data[0][0];
    let montantTotal = 0;
    for(let i=1; i<=nbPass;i++){
        document.getElementById("pass"+i).innerHTML = "<th scope=\"row\">"+i+"</th> <td>"+data[1][i][0]+"</td> <td>"+data[1][i][1]+"</td> <td>"+data[1][i][2]+"</td> <td>"+data[1][i][3]+"</td>"
        document.getElementById("billet"+i).innerHTML = "Billet pour le vol "+data[0][1]+" : "+data[0][2]+" "+data[0][3]+" - "+data[0][4]+" "+data[0][5]+"<br>Date : "+data[0][6]+" Heure départ : "+data[0][7]+" Heure arrivée : "+data[0][8]+" | Prix : "+data[1][i][4];
        
    }
    document.getElementById("total").innerHTML = "Le montant total des "+nbPass+" billets est de : "+montantTotal+"$.";
}

ajaxRequest("GET","controlleur.php?func=infoConfirmation",createConfirmation)