$(document).ready(function() {
   
    $('#subcat_button').on('click', function(event){
        $('.results').fadeIn('1000').html('Searching ...');
        event.preventDefault();
        
        var cat = $('#cat option:selected').text();
        var subcat = $('#subcat option:selected').text();
        cat = cat.replace(' ', '+');
        subcat = subcat.replace(' ', '+');        
        var order = $('#order1').val();
        var maxprice = $('#maxprice1').val();
        
        var vbls_string = '';
        vbls_string += (cat!="") ? "cat=" + cat + "&" : "";
        vbls_string += (subcat!="") ? "subcat=" + subcat + "&" : "";
        vbls_string += (order!="") ? "order=" + order  + "&" : "";
        vbls_string += (maxprice!="") ? "maxprice=" + maxprice : "";
        
        if ((vbls_string.slice(-1) == "&") || (vbls_string.slice(-1) == "?") ){
            vbls_string = vbls_string.slice(0,-1);
        }
        
        document.location = "index.php?" + vbls_string;
        
    })
    
});