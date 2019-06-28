/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you require will output into a single css file (app.css in this case)
require('../css/app.css');

// Need jQuery? Install it with "yarn add jquery", then uncomment to require it.
const $ = require('jquery');

$('.addInOrderBtn').on( "click", function() {
    console.log( $( this )[0].getAttribute('productId') );
    var selector = 'input[name='+$( this )[0].getAttribute('productId')+']';
    $(selector)[0].value =
        parseInt($(selector)[0].value)+1;
    console.log($(selector));

});