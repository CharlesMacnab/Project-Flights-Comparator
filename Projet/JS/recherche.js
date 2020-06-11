var numberSearch;
function createFormSearch(data){
    
    console.log(data)
    
    numberSearch = data[0];
    
    var i=1;
    console.log(numberSearch);
    for (i; i<=numberSearch; i++){
        let flight = data[1][i];
        $('#formPassenger').append("<tr><th scope=\"row\">"+flight[1]+"</th><td>"+flight[2]+"</td><td>"+flight[3]+" - "+$flight[4]+"</td><td>"+flight[5]+"</td><td><input type=\"radio\" class=\"form-check-input\" name=\"fly\" value=\""+$flight[0]+"\" id=\"check"+i+"\"></td></tr>");
    }    
}

function reservationVol(){
    let valeur;
    for(let i = 1;i<=numberSearch;i++){
        if (document.getElementById('check'+i).checked) {
            valeur = document.getElementById('check'+i).value;
        }
    }
    ajaxRequest("GET", "http://localhost/Projet-CIR2/PHP/controlleur.php", null, "func=reservation&id="+valeur);
    window.location.href = "../HTML/confirmation.html";
}

ajaxRequest("GET", "http://localhost/Projet-CIR2/PHP/controlleur.php",createFormSearch,"func=getSearch");