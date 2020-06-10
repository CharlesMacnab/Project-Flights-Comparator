/**
 * @Author: Thibault Napoléon <Imothep>
 * @Company: ISEN Yncréa Ouest
 * @Email: thibault.napoleon@isen-ouest.yncrea.fr
 * @Created Date: 23-Jan-2018 - 17:00:53
 * @Last Modified: 08-Dec-2019 - 19:12:57
 */

'use strict';

//------------------------------------------------------------------------------
//--- ajaxRequest --------------------------------------------------------------
//------------------------------------------------------------------------------
// Perform an Ajax request.
// \param type The type of the request (GET, DELETE, POST, PUT).
// \param url The url with the data.
// \param callback The callback to call where the request is successful.
// \param data The data associated with the request.
function ajaxRequest(type, url, callback= null, data = null)
{
    let xhr;

    // Create XML HTTP request.
    xhr = new XMLHttpRequest();
    if (type == 'GET' && data != null)
        url += '?' + data;
    xhr.open(type, url);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    // Add the onload function.
    xhr.onload = () =>
    {
        httpErrors(xhr.status);
        if (callback!=null)
            callback(JSON.parse(xhr.responseText));
    };

    // Send XML HTTP request.
    xhr.send();
}

//------------------------------------------------------------------------------
//--- httpErrors ---------------------------------------------------------------
//------------------------------------------------------------------------------
// Display an error message accordingly to an error code.
// \param errorCode The error code (HTTP status for example).
function httpErrors(errorCode)
{
    let messages = {
        10: 'Incorrect login, there is already a user with this login',
        11: 'Incorrect password',
        12: 'Incorrect login',
        400: 'Requête incorrecte',
        401: 'Authentifiez vous',
        403: 'Accès refusé',
        404: 'Page non trouvée',
        500: 'Erreur interne du serveur',
        503: 'Service indisponible'
    };

    // Display error.
    if (errorCode in messages)
    {
        $('#errors').html('<i class="fa fa-exclamation-circle"></i> <strong>' +
            messages[errorCode] + '</strong>');
        $('#errors').show();
    }
}
