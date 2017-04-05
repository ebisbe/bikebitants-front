<a href="{{ route('shop.slug', ['slug' => $product->slug]) }}"
   onclick="onProduct{{ $iteration }}Click(); return !ga.loaded;"
   class="btn btn-transparent btn-sm add-to-cart">
    @if($product->stock == 0)
        @lang('catalogue.read_more')
            @elseif($product->variations->count() > 1)
                @lang('catalogue.choose_options')
                    @else
                        @lang('catalogue.view')
                            @endif
</a>