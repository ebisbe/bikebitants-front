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
            .done(function (jqXHR) {
                $('#vue-cart-update').val(jqXHR).trigger('change');
            })
            .fail(function () {

            })
            .always(function () {
                form.find('.js-add-button')
                    .prop("disabled", false)
                    .find('i')
                    .toggleClass('fa-spinner fa-shopping-cart fa-spin');
            });
    });

    $('.js-shop-add-button').click(function (event) {
        var that = $(this);
        //console.log('triggered and disabled!');
        event.preventDefault();
        that.prop("disabled", true)
            .find('i')
            .toggleClass('fa-spinner fa-shopping-cart fa-spin');

        var quantity = that.data('quantity');
        var product_id = that.data('product_id');
        var token = that.data('token');
        var product_name = that.data('product_name');

        $.ajax({
                url: that.data('action'),
                data: {
                    'quantity': quantity,
                    'product_id': product_id,
                    '_token': token
                },
                method: 'post'
            })
            .done(function (jqXHR) {
                $('#vue-cart-update').val(jqXHR).trigger('change');
            })
            .fail(function () {

            })
            .always(function () {
                that.prop("disabled", false)
                    .find('i')
                    .toggleClass('fa-spinner fa-shopping-cart fa-spin');
            });
    });

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
            animateIn: 'fadeIn'
        });
    });

    $('#js-catalogue').on('change', '.js-change', function (event) {
        var that = $(this);
        that.parents('form').submit();
    });

    $('#js-shipping').on('change', '.js-change', function (event) {
        var that = $(this);
        var country = $('.js-country').val();
        var region = that.val();
        var token = that.data('token');

        $('#vue-token').val(token).trigger('change');
        $('#vue-country').val(country).trigger('change');
        $('#vue-region').val(region).trigger('change');
    });
    $('#js-shipping .js-change').trigger('change');
});
