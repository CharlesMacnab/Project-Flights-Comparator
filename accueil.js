





function setNumber(){
    let nbPass = document.getElementById("passengers").value;
    ajaxRequest("GET", "http://localhost/Projet/controlleur.php",null,"func=infoVol&nbPass="+nbPass);
    window.location.href = "accueilv2.html";

    
}
    


