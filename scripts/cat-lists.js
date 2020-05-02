$(document).ready(function() {
    
    $('#subcat').css('opacity', 0.5);
 
    $.ajax({
        cache: false,
        url: 'ajax/cat-list.ajax.php',
        type: 'GET',
       'success' : function(response) {
            var cat_result = response;
            $('#cat').html('<option selected value="Select category">Select category</option>' + cat_result);
        }
    });
    
 
    $('#cat').on('change', function() {
        $('#subcat').html('<option selected value="Select subcategory">Select subcategory</option>');
        var cat = this.value;
        if (cat=="Select category") {
            $('#subcat').css('opacity',0.5);
        } else {
            $('#subcat').css('opacity',1);
        
            $.ajax({
                cache: false,
                url: 'ajax/subcat-list.ajax.php',
                type: 'GET',
                data: {
                     'cat' : cat
                },
                'beforeSend' : function(response) {
                    $('#subcat').addClass('loading');
                },                
               'success' : function(response) {
                    var subcat_result = response;
                    $('#subcat').html('<option selected value="Select subcategory">Select subcategory</option>' + subcat_result);
                },
                'complete' : function(response) {
                     $('#subcat').removeClass('loading');
                }
            });
        }
      
    });

});