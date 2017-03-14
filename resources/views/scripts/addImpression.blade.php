<script type="application/javascript">
    ga('ec:addImpression', {!! $product->gaProduct($view_name, $iteration) !!});
    //ga("send", "event", "Enhanced-Ecommerce", "load", "product_impression_{{ $view_name }}", {"nonInteraction": 1});

    function onProduct{{$product->external_id}}Click() {
        ga('ec:addProduct', {!! $product->gaProduct($view_name, $iteration) !!});
        ga('ec:setAction', 'click', {list: '{{ $view_name }}'});

        // Send click with an event, then send user to product page.
        ga('send', 'event', 'UX', 'click', '{{ $view_name }}', {
            hitCallback: function() {
                document.location = '{{ route('shop.slug', ['slug' => $product->slug]) }}';
            }
        });
    }
</script>