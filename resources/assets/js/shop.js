/*------------------------------
 DOCUMENT READY
 ------------------------------*/
$(document).ready(function () {
    $('.js-add-to-cart').submit(function (event) {
        var form = $(this);
        //console.log('triggered and disabled!');
        event.preventDefault();
        form.find('.js-add-button')
            .prop("disabled", true)
            .find('i')
            .toggleClass('fa-spinner fa-shopping-cart fa-spin');
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
                form.find('.js-add-button')
                    .prop("disabled", false)
                    .find('i')
                    .toggleClass('fa-spinner fa-shopping-cart fa-spin');
            });
    });

    $('#js-popup').submit(function (event) {
        var form = $(this);
        var response = classSpan =  '';

        event.preventDefault();
        form.find('div').removeClass('has-error')
            .find('.js-popup-send').prop("disabled", true);
        form.find('.js-popup-message').html('');

        $.ajax({
                url: form.attr('action'),
                data: form.serialize(),
                method: 'post'
            })
            .done(function (jqXHR) {
                response = jqXHR.response;
                classSpan = 'text-primary';
                $('#modal-hide').attr('checked', true);
            })
            .fail(function (jqXHR) {
                form.find('div').addClass('has-error');
                response = jqXHR.responseJSON.email[0];
                classSpan = 'text-danger';
            })
            .always(function () {
                form.find('.js-popup-send')
                    .prop("disabled", false);
                form.find('.js-popup-message')
                    .html(response)
                    .addClass(classSpan);
            });
    });
});
