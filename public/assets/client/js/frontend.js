(function($) {

    $("body").on("click", "button[type=submit]", function(e) {
        var text = $(this).html();

        if (text == "Loading...") {
            e.preventDefault();

            alert('Please do not submit twice');
        }else{
            $(this).html("Loading...");
        }
    });

})(jQuery);
