'use strict';

ajaxRequest('GET', 'BDD/request.php/vols/', displayVols);
ajaxRequest('GET', 'BDD/request.php/depart/', autocompleteDepart);

function displayVols(vols) {
    //console.log(vols);
    /*
    for(let vol of vols) {
        console.log(vol.id);
        console.log(vol.title);
    }
     */
}

function autocompleteVilles(villes) {

    var liste = [];
    //alert(villes);
    //alert(liste);

    for(let ville of villes){
        //console.log(ville);
        //alert(ville);
        //console.log(ville.depVille);
        //alert(ville.depVille);
        liste.push(ville.city + " (" + ville.airportCode + ")");
        //console.log(liste);
        //alert(liste);
    }

    alert(liste);

    $('#depart').autocomplete({
        source : liste,
        minLength: 3,
	delay: 200
    });
	


    $('#arrivee').autocomplete({
        source : liste,
        minLength: 3,
	delay: 200
    });
}
