/*------------------------------
 DOCUMENT READY
 ------------------------------*/
$(document).ready(function() {
    $('.js-add-to-cart').submit(function( event ) {

        event.preventDefault();
        var form = $(this);
        $.ajax( {
            url: form.attr('action'),
            data: form.serialize()
        })
            .done(function () {
                alert("success");
            })
            .fail(function () {
                alert("error");
            })
            .always(function () {
                alert("complete");
            });
    });
});
