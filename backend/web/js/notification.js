// define(['jquery', 'application', 'modal'], function ($, application, modal) {
//     'use strict';
var socket = io.connect('https://automechta.by:3000');

socket.on('notification', function (data) {

    var message = JSON.parse(data);
    alert ( message.name);

    $( "#notifications" ).prepend( "<p><strong>" + message.name + "</strong>: " + message.message + "</p>" );

});

// });
