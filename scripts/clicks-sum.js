$(document).ready(function(){
      refreshClicks();
});
  
  
function refreshClicks(){
    $('#clicks_sum').load('ajax/clicks-sum.ajax.php', function(){
       setTimeout(refreshClicks, 5000);
    });
}