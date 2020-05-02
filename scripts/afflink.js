$(document).ready(function() {

   $("button.get_deal, button.get_deal_sm").on('mouseover' , function() {
      
      var id = $(this).attr('id');
      var button_text = $(this).html();
      $.ajax({
           cache: false,
           url: 'ajax/afflink.ajax.php',
           type: 'POST',
           data: { 'id' : id },
           'success' : function(response) {
               var link = response;
               link = "http://coupontru.mp/" + link;
               $('div.get_deal').html("<a target='_blank' href='" + link + "'><button class='btn btn-primary get_deal'>" + button_text + " </button></a>");
               $('div.get_deal_sm').html("<a target='_blank' href='" + link + "'><button class='btn btn-primary get_deal_sm'>" + button_text + " </button></a>");
           }
      });

   });

   $("button.get_deal, button.get_deal_sm").on('touchstart' , function() {
      

      var id = $(this).attr('id');
      var button_text = $(this).html();
      $.ajax({
           cache: false,
           url: 'ajax/afflink.ajax.php',
           type: 'POST',
           data: { 'id' : id },
           'success' : function(response) {
               var link = response;
               link = "http://coupontru.mp/" + link;
               $('div.get_deal').html("<a target='_blank' href='" + link + "'><button class='btn btn-primary get_deal'>" + button_text + " </button></a>");
               $('div.get_deal_sm').html("<a target='_blank' href='" + link + "'><button class='btn btn-primary get_deal_sm'>" + button_text + " </button></a>");
           }
      });
   });
   
  
    
});