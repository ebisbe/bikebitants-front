@if(isset($rating))
    <div class="product-rating">
        @php
        for($count = 1; $count < 6; $count ++)
        {
            if($count <= floor($rating)) {
                echo '<i class="fa fa-star"></i>';
            } elseif($rating - floor($rating) > 0.5 && (ceil($rating)) == $count) {
                echo '<i class="fa fa-star-half-full"></i>';
            } else {
                echo '<i class="fa fa-star-o"></i>';
            }
        }
        @endphp
    </div>
@else
    <div class="product-rating text-muted">
        @lang('catalogue.no_rating')
    </div>
@endif