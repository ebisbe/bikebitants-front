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

    $('#js-shipping').on('change', '.js-country', function (event) {
        var country = $(this).val();
        var newOptions = $(this).data(country.toLowerCase());

        var $el = $(".js-change");
        $el.empty(); // remove old options
        $.each(newOptions, function(key,value) {
            $el.append($("<option></option>")
                .attr("value", value._id).text(value.name));
        });

        $el.change();
    });
    $('.js-country').change();

    $('#js-shipping').on('change', '.js-change2', function (event) {
        var that = $(this);
        var country = $('.js-country2').val();
        var state = that.val();
    });

    $('#js-shipping').on('change', '.js-country2', function (event) {
        var country = $(this).val();
        var newOptions = $(this).data(country.toLowerCase());

        var $el = $(".js-change2");
        $el.empty(); // remove old options
        $.each(newOptions, function(key,value) {
            $el.append($("<option></option>")
                .attr("value", value._id).text(value.name));
        });

        $el.change();
    });
    $('.js-country2').change();

    if($(window).width() <= 767) {
        $('#widget-categories-collapse, #widget-price-collapse').collapse('hide');
    }
});
