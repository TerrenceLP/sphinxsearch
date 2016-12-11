// submit form for validation clientside first
$(function() {
    $('#searchform').validate({// initialize the plugin
        // your rules and options,
        submitHandler: function(form) {
			form.submit();
			var searchdata = $('#searchform').serialize();
            $.ajax({
                type:'post',
                url: 'searcher.php',
                data: searchdata,
                done: function(data) {
                    $("#lead").html(data).fadeIn();
					console.log("in the success");
                },
                fail: function(data) {
                    console.log('Ajax request not recieved!');
                }
            });
			
            // resets fields
            $("#searchform").each(function() {
                this.reset();
            });

            return false; // blocks redirect after submission via ajax
        }
    });
});