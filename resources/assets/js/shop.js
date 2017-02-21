/*------------------------------
 DOCUMENT READY
 ------------------------------*/
$(document).ready(function () {
    $('#js-popup').submit(function (event) {
        var form = $(this);
        var response = classSpan = '';

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

    $('#product-quickview').on('show.bs.modal', function (event) {
        var modal = $(this);

        $.each($(event.relatedTarget).data('product'), function (key, value) {
            var text = '';
            if (value !== null && typeof value === 'object') {
                $.each(value, function (key, value) {
                    text += value;
                });
            } else {
                text = value;
            }
            modal.find('.modal-' + key).html(text);

        });

        modal.find(".product-carousel-wrapper").removeClass('hidden');
        $("#product-carousel-modal").owlCarousel({
            items: 1,
            animateOut: 'fadeOut',
            animateIn: 'fadeIn',
        });
    });

    $('#js-catalogue').on('change', '.js-change', function (event) {
        var that = $(this);
        that.parents('form').submit();
    });

    $('#js-shipping').on('change', '.js-change', function (event) {
        var that = $(this);
        var country = $('.js-country').val();
        var state = that.val();

        Bus.$emit('shippingDestinationUpdate', { state: state, country: country});
    });

    if($(window).width() <= 767) {
        $('#widget-categories-collapse, #widget-price-collapse').collapse('hide');
    }
});
