@if(isset($rating))
    <div class="product-rating">
        @php
        for($count = 1; $count < 6; $count ++)
        {
            if($count <= floor($rating)) {
                echo '<i class="fa fa-star"></i>';
            } elseif($rating - floor($rating) > 0.5) {
                echo '<i class="fa fa-star-half"></i>';
            } else {
                echo '<i class="fa fa-star-o"></i>';
            }
        }
        @endphp
    </div>
@else
    <div class="product-rating">
        No rating available. Be the first to rate this product.
    </div>
@endif