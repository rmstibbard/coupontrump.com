$(document).ready(function() {
    var wrapper         = $(".input_fields_wrap"); //Fields wrapper
    var add_button      = $(".add_field_button"); //Add button ID
   
    var x = 1; //initial text box count
    $(add_button).click(function(e){ //on add input button click
        e.preventDefault();
            x++; //text box increment
            $(wrapper).append("<div><input name='url[]' id='url[]' class='form-control'></div>\n<div><input name='url[]' id='url[]' class='form-control'></div>\n<div><input name='url[]' id='url[]' class='form-control'></div>\n<div><input name='url[]' id='url[]' class='form-control'></div>\n<div><input name='url[]' id='url[]' class='form-control'></div>\n"); //add input box
    });
    
});