$(document).ready(function() {
    $("img.lazy").Lazy({
        enableThrottle: true,
        throttle: 250,
        threshold: 250,
        effect: "fadeIn",
        effectTime: 1000
    });
    
    $('#author_keyword_button').on('click', function(event){
        $('.results').html('Searching ...');
    });
    
});