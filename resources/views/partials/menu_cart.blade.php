@inject('carts', 'App\Cart')
<li class="dropdown navbar-cart hidden-xs">
    <a href="#" class="dropdown-toggle"
       data-toggle="dropdown"
       data-hover="dropdown"
       data-delay="300"
       data-close-others="true">
        <i class="fa fa-shopping-cart"></i>
    </a>
    <ul class="dropdown-menu">
        @foreach($carts->with('product.brand')->get() as $cart)
            <li>
                <div class="row">
                    <div class="col-sm-3">
                        <img src="/img/70/{{ $item->product->images()->first()->path }}" alt="{{ $item->product->images()->first()->alt }}" class="img-responsive">
                    </div>
                    <div class="col-sm-9">
                        <h4>
                            <a href="{{ route('shop.product', ['slug' => $cart->slug]) }}">{{ $cart->product->name }}</a>
                        </h4>
                        <p>{{ $cart->quantity }}x - {{ $cart->price }}{{ $cart->product->currency }}</p>
                        <form method="POST" action="/cart/{{ $cart->_id }}">
                            <input type="hidden" name="_method" value="DELETE"/>
                            {{ csrf_field() }}
                            <button class="btn btn-link remove no-padding" type="submit">
                                <i class="fa fa-times-circle"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </li>
            @endforeach

                    <!-- CART ITEM - START -->
            <li>
                <div class="row">
                    <div class="col-sm-6">
                        <a href="{{ route('cart.index') }}" class="btn btn-primary btn-block">View Cart</a>
                    </div>
                    <div class="col-sm-6">
                        <a href="{{ route('checkout.index') }}" class="btn btn-primary btn-block">Checkout</a>
                    </div>
                </div>
            </li>
            <!-- CART ITEM - END -->

    </ul>
</li>