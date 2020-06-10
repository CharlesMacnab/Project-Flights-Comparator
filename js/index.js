
var numberPassenger = 0;


function createFormPassenger(){
    window.location.href = "page/passager.html";
    alert(numberPassenger);
    var form = document.getElementById('formPassenger');
    var i=1;
    console.log(numberPassenger);
    for (i; i<=numberPassenger; i++){
        form.innerHTML = "<div class=\"row\"><h1>Passager N°" + i + "</h1> </div><div class=\"form-row\"> <div class=\"form-group col-md-6\"> <label for=\"inputText\">Nom</label> <input type=\"text\" class=\"form-control\" id=\"inputText\" required> </div><div class=\"form-group col-md-6\"><label for=\"inputText\">Prénom</label><input type=\"text\" class=\"form-control\" id=\"inputText\" required></div></div><div class=\"form-group\"><label for=\"inputEmail4\">Email</label><input type=\"email\" class=\"form-control\" id=\"inputEmail4\" required></div><div class=\"form-group\"><label for=\"start\">Date de Naissance</label><input type=\"date\" id=\"start\" name=\"trip-start\" required></div><br>"
    }
    
}


function setNumber(){
    numberPassenger = document.getElementById('passengers').value;
    
    createFormPassenger();
    console.log(numberPassenger);
}
    




