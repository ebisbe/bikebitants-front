<span class="price {{ $class ?? '' }}" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
    @if($product->is_discounted)
        <del><span class="amount">{{ $product->range_real_price }}</span></del>
    @endif
    <ins><span class="amount">{{ $product->range_price }}</span></ins>
    <small class="hidden-xs">{{ trans('catalogue.iva') }}</small>
    <meta itemprop="price" content="{{ $product->lower_price }}"/>
    <meta itemprop="priceCurrency" content="{{ $product->currency }}"/>
    <link itemprop="availability" href="http://schema.org/{{ $product->stock > 0 ? 'InStock' : 'OutOfStock' }}"/>

    <span itemprop="priceSpecification" itemscope itemtype="http://schema.org/PriceSpecification">
            <meta itemprop="price" content="{{ $product->lower_price }}"/>
            <meta itemprop="minPrice" content="{{ $product->lower_price }}"/>
            <meta itemprop="maxPrice" content="{{ $product->higher_price }}"/>
            <meta itemprop="priceCurrency" content="{{ $product->currency }}"/>
    </span>
</span>