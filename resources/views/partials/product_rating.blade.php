@if(isset($rating))
    <div class="product-rating">
        @include('partials.rating', ['rating' => $rating])
    </div>
    <div itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating">
            <meta itemprop="ratingValue" content="{{ $rating }}">
            <meta itemprop="bestRating" content="5">
            <meta itemprop="ratingCount" content="{{ $total_reviews }}">
            <meta itemprop="reviewCount" content="{{ $total_reviews }}">
    </div>

@else
    <div class="product-rating text-muted">
        @lang('catalogue.no_rating')
    </div>
@endif