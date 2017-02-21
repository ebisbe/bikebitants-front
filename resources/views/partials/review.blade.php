<!-- REVIEW - START -->
<div class="media"
     itemprop="review"
     itemscope
     itemtype="http://schema.org/Review"
     id="review-{{ $review->_id }}">
    <div class="media-left">
        <img class="media-object" alt="" src="/images/default-avatar.png">
    </div>
    <div class="media-body">
        <h3 class="media-heading" itemprop="author">{{ $review->name }}</h3>
        <div class="meta">
            <span class="date" itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating">
                <meta itemprop="ratingValue" content="{{ $review->rating }}">
                @include('partials.rating', ['rating' => $review->rating])
            </span>
            <span class="date">
                <time itemprop="datePublished"
                      datetime="{{ $review->created_at }}">{{ $review->created_at }}
                </time>
            </span>
            @if(!empty($reply))
                <a data-toggle="modal" data-target="#add-review">Reply</a>
            @endif
        </div>
        <p itemprop="description">{{ $review->comment }}</p>
        @foreach($review->children as $children)
            @include('partials.review', ['review' => $children, 'reply' => false])
        @endforeach
    </div>
</div>
<!-- REVIEW - END -->