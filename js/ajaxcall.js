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
