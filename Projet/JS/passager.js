var numberPassenger;

function createFormPassenger(data){
    
    numberPassenger = data[0];
    var i=1;
    for (i; i<=numberPassenger; i++){
        $('#formPassenger').append("<div class=\"row\"><h1>Passager N°" + i + "</h1> </div><div class=\"form-row\"> <div class=\"form-group col-md-6\"> <label for=\"nom"+i+"\">Nom</label> <input type=\"text\" class=\"form-control\" id=\"nom"+i+"\" required> </div><div class=\"form-group col-md-6\"><label for=\"prenom"+i+"\">Prénom</label><input type=\"text\" class=\"form-control\" id=\"prenom"+i+"\" required></div></div><div class=\"form-group\"><label for=\"email"+i+"\">Email</label><input type=\"email\" class=\"form-control\" id=\"email"+i+"\" required></div><div class=\"form-group\"><label for=\"date"+i+"\">Date de Naissance</label><input type=\"date\" id=\"date"+i+"\" name=\"trip-start\" required></div><br>")
    }
    
}

function setPassager() {
    let data = "";
    for(let i=1; i<=numberPassenger;i++){
        let nom = document.getElementById("nom"+i).value;
        let prenom = document.getElementById("prenom"+i).value;
        let mail = document.getElementById("email"+i).value;
        let date = document.getElementById("date"+i).value;
        let passenger = "&passenger="+i+" "+nom+" "+prenom+" "+date+" "+mail;
        data += passenger;
        ajaxRequest("GET", "http://localhost/Projet-CIR2/controlleur.php",null,"func=setPassenger"+data);          
    }

    window.location.href = "recherche.html";
}

ajaxRequest("GET", "http://localhost/Projet-CIR2/controlleur.php",createFormPassenger,"func=getInfoVol");