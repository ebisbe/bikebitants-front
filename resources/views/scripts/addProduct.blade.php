<script type="application/javascript">
    ga('ec:addProduct', {
        'id': '{{ $product['id'] }}',
        'name': '{{ $product['name'] }}',
        'brand': '{{ isset($product['attributes']) ? $product['attributes']['brand'] : '' }}',
        'variant': '{{ implode(', ', $product->attributes->properties) }}',
        'price': '{{ $product->getPriceWithConditions() }}',
        'quantity': '{{ $product->quantity }}'
    });
</script>