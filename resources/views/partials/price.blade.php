<span class="price" style="{{ isset($style) ? $style : '' }}">
    @if($product->is_discounted)
        <del><span class="amount">{{ $product->range_real_price }}</span></del>
    @endif
    <ins><span class="amount">{{ $product->range_price }}</span></ins>
</span>