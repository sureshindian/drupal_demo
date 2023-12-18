(function ($, Drupal) {
    Drupal.behaviors.form_submit_processor = {
        attach: function (context, settings) {
          $('input').click(function(){
            var test  = $(this).text();
            console.log("test"+test);
          })  
          $("form#custom_user_details").submit(function(e) {
            alert("submit success");
          });
        }
      }

}(jQuery, Drupal));