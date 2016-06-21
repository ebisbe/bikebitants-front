/*------------------------------
 DOCUMENT READY
 ------------------------------*/
$(document).ready(function () {
    $('.js-add-to-cart').submit(function (event) {
        var that = $(this);
        //console.log('triggered and disabled!');
        event.preventDefault();
        that.find('.js-add-button')
            .prop("disabled", true)
            .find('i')
            .toggleClass('fa-spinner fa-shopping-cart fa-spin');
        var form = $(this);
        $.ajax({
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
                that.find('.js-add-button')
                    .prop("disabled", false)
                    .find('i')
                    .toggleClass('fa-spinner fa-shopping-cart fa-spin');
            });
    });
});
