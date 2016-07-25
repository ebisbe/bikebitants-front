<li class="dropdown navbar-cart hidden-xs">
    <a href="#" class="dropdown-toggle"
       data-toggle="dropdown"
       data-hover="dropdown"
       data-delay="300"
       data-close-others="true">
        <i class="fa fa-shopping-cart"></i>
    </a>
    @if(!Cart::isEmpty())
        <ul class="dropdown-menu">
            @foreach(Cart::getContent() as $cart)
                @php
                    $item = $cart->attributes->product;
                @endphp
                <li>
                    <div class="row">
                        <div class="col-sm-3">
                            <img src="/img/70/{{ $item->images()->first()->filename }}"
                                 alt="{{ $item->images()->first()->alt }}" class="img-responsive">
                        </div>
                        <div class="col-sm-9">
                            <h4>
                                <a href="{{ route('shop.product', ['slug' => $item->slug]) }}">{{ $item->name }}</a>
                            </h4>
                            <p>{{ $cart->quantity }}x - {{ $cart->price }}{{ $item->currency }}</p>
                            <form method="POST" action="/cart/{{ $item->_id }}">
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
    @else
        <ul class="dropdown-menu">
            <li>Your cart is empty</li>
            <li>
                <div class="row">
                    <div class="col-sm-12">
                        <a href="{{ route('shop.catalogue') }}" class="btn btn-primary btn-block">Go Shopping!</a>
                    </div>
                </div>
            </li>
        </ul>
    @endif
</li>