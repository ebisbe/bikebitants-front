<span class="price {{ $class ?? '' }}" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
    @if($product->is_discounted)
        <del><span class="amount">{{ $product->range_real_price }}</span></del>
    @endif
    <ins><span class="amount">{{ $product->range_price }}</span></ins>
    <small>{{ trans('catalogue.iva') }}</small>
    <meta itemprop="price" content="{{ $product->lower_price }}"/>
    <meta itemprop="priceCurrency" content="{{ $product->currency }}"/>
    <link itemprop="availability" href="http://schema.org/{{ $product->stock > 0 ? 'InStock' : 'OutOfStock' }}"/>

</span>