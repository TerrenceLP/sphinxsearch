//  RequireJS info
// 'jquery' returns the jQuery object into '$'
// 'bootstrap' does not return an object. Must appear at the end
require(["jquery", "validate", "additional-methods", "ie-emulation-modes-warning", "ie10-viewport-bug-workaround", "bootstrap"], function (jQuery, validate, additional_methods, ie_emulation_modes_warning, ie10_viewport_bug_workaround) {

  $("#searchform").submit(function(e) {
      "use strict";
  	e.preventDefault(); // avoid to execute the actual submit of the form.
      var url = "php/searcher.php"; // the script where you handle the form input.
      $.ajax({
             type: "POST",
             url: url,
             data: $("#searchform").serialize(), // serializes the form's elements.
             success: function(data)
             {
                 $("#lead").html(data).fadeIn();
             },
             fail: function(data) {
                  console.log('Ajax request for ' + data + ' not recieved!');
             }
           });
  });

});
