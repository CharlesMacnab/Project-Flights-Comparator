'use strict';

ajaxRequest('GET', 'BDD/request.php/vols/', displayVols);
ajaxRequest('GET', 'BDD/request.php/villes/', autocompleteVilles);

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

    $('#depAir').autocomplete({
        source : liste,
        minLength: 3,
	delay: 200
    });
	


    $('#arrAir').autocomplete({
        source : liste,
        minLength: 3,
	delay: 200
    });
}
