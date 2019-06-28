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
    var selector = 'input[name='+$( this )[0].getAttribute('productId')+']';
    $(selector)[0].value =
        parseInt($(selector)[0].value)+1;
});

$('form.createOrderForm').on('click', function () {
    var selector = '.productCount';
    data = '';
    for( var $i=0; $i < $(selector).length ; $i++){
        if($(selector)[$i].value > 0){
            data += $(selector)[$i].getAttribute('name') +'='+ $(selector)[$i].value;
            data += '&&';
        }
    }
    if(data ===''){
        alert('не выбран ни один товар');
        return false;
    }
    var url = ($( this )[0].getAttribute('action'));
    var type = $( this )[0].getAttribute('method');
    // я бы просто просериализовал данные и на сервере уже разобрался
    // Но нужно провалидировать данные
    // поэтому не отправляю пустые продукты
    // var data = ($(this).serialize());
    $.ajax({
        type: type,
        url: url,
        data: data,
        success: function(data){
            alert( data.msg );
        }
    });
});

