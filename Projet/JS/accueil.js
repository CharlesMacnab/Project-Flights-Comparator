function setNumber(){
    let nbPass = document.getElementById("passengers").value;
    let depAir = document.getElementById("depAir").value;
    let arrAir = document.getElementById("arrAir").value;
    let date = document.getElementById("date").value;
    if(nbPass!=null && depAir!=null && arrAir!=null && date!=null){
        ajaxRequest("GET", "http://localhost/Projet-CIR2/controlleur.php",null,"func=infoVol&nbPass="+nbPass+"&depAir="+depAir+"&arrAir="+arrAir+"&date="+date);
        window.location.href = "accueilv2.html";
    }
}
    


