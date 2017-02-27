<script type="application/javascript">
    ga('ec:addImpression', {!! $product->gaProduct($view_name, $iteration) !!});
    ga("send", "event", "Enhanced-Ecommerce", "load", "product_impression_{{ $view_name }}", {"nonInteraction": 1});
</script>