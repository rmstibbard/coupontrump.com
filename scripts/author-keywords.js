$(document).ready(function() {
   
    $('#author_keyword_button').on('click', function(event){
        $('.results').fadeIn('1000').css('color','black').html('Searching ...');
        event.preventDefault();
        
        var author = $('#author').val();
        var keywords = $('#keywords').val();
        var order = $('#order2').val();
        var maxprice = $('#maxprice2').val();
        
        author = author.replace(/\s/g, "+");
        
        keywords = keywords.replace(',', " ");
        keywords = keywords.replace('+and+', " ");
        keywords = keywords.replace(/\:/g, "+");
        keywords = keywords.replace(/&/g, "+");
        keywords = keywords.replace(/\s/g, "+");
        keywords = keywords.replace(/\s+/g, "+");
        keywords = keywords.replace(/\+\+/g, "+");
                        
        var vbls_string = '';
        vbls_string += (author!="") ? "author=" + author + "&" : "";
        vbls_string += (keywords!="") ? "keywords=" + keywords + "&" : "";
        vbls_string += (order!="") ? "order=" + order  + "&" : "";
        vbls_string += (maxprice!="") ? "maxprice=" + maxprice : "";
        
        if ((vbls_string.slice(-1) == "&") || (vbls_string.slice(-1) == "?") ){
            vbls_string = vbls_string.slice(0,-1);
        }
        
        document.location = "index.php?" + vbls_string;
        
    })
    
});