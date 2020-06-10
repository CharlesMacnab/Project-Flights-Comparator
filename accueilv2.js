function createFormPassenger(data){
    
    console.log(data)
    let numberPassenger = data[0];
    var i=1;
    console.log(numberPassenger);
    for (i; i<=numberPassenger; i++){
        $('#formPassenger').append("<div class=\"row\"><h1>Passager N°" + i + "</h1> </div><div class=\"form-row\"> <div class=\"form-group col-md-6\"> <label for=\"inputText\">Nom</label> <input type=\"text\" class=\"form-control\" id=\"inputText\" required> </div><div class=\"form-group col-md-6\"><label for=\"inputText\">Prénom</label><input type=\"text\" class=\"form-control\" id=\"inputText\" required></div></div><div class=\"form-group\"><label for=\"inputEmail4\">Email</label><input type=\"email\" class=\"form-control\" id=\"inputEmail4\" required></div><div class=\"form-group\"><label for=\"start\">Date de Naissance</label><input type=\"date\" id=\"start\" name=\"trip-start\" required></div><br>")
    }
    
}

ajaxRequest("GET", "http://localhost/Projet/controlleur.php",createFormPassenger,"func=getInfoVol");