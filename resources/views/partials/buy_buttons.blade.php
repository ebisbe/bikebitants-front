@if($product->stock == 0)
    <a href="{{ route('shop.slug', ['slug' => $product->slug]) }}"
       onclick="onProduct{{ $iteration }}Click(); return !ga.loaded;"
       class="btn btn-transparent btn-sm add-to-cart">
        @lang('catalogue.read_more')
    </a>
@elseif($product->variations->count() > 1)
    <a href="{{ route('shop.slug', ['slug' => $product->slug]) }}"
       onclick="onProduct{{ $iteration }}Click(); return !ga.loaded;"
       class="btn btn-transparent btn-sm add-to-cart">
        @lang('catalogue.choose_options')
    </a>
@else
    <cart-add :quantity="1"
              product_id="{{ $product->_id }}"
              text="catalogue.add_and_buy"
              :show_icon="true"
              :checkout="true"
              button_class="btn btn-transparent btn-sm">
    </cart-add>
@endif