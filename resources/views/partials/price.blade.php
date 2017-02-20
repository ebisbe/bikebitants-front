<span class="price {{ $class ?? '' }}">
    @if($product->is_discounted)
        <del><span class="amount">{{ $product->range_real_price }}</span></del>
    @endif
    <ins><span class="amount">{{ $product->range_price }}</span></ins>
    <small>{{ trans('catalogue.iva') }}</small>
    <meta itemprop="price" content="{{ $product->lower_price }}"/>
        <meta itemprop="priceCurrency" content="{{ $product->currency }}"/>
</span>