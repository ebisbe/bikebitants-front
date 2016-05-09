/*------------------------------
 DOCUMENT READY
 ------------------------------*/
$(document).ready(function() {
    $('.js-add-to-cart').submit(function( event ) {

        event.preventDefault();
        var form = $(this);
        $.ajax( {
            url: form.attr('action'),
            data: form.serialize(),
            method: 'post'
        })
            .done(function () {
                //console.log("success");
            })
            .fail(function () {
                //console.log("error");
            })
            .always(function () {
                //console.log("complete");
            });
    });
});
