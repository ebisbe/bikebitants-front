<!-- REVIEW - START -->
<div class="media">
    <div class="media-left">
        <img class="media-object" alt="" src="/images/default-avatar.png">
    </div>
    <div class="media-body">
        <h3 class="media-heading">{{ $review->name }}</h3>
        <div class="meta">
            <span class="date">{{ $review->created_at }}</span>
            @if(!empty($reply))
                <a data-toggle="modal" data-target="#add-review">Reply</a>
            @endif
        </div>
        <p>{{ $review->comment }}</p>
        @foreach($review->children as $children)
            @include('partials.review', ['review' => $children, 'reply' => false])
        @endforeach
    </div>
</div>
<!-- REVIEW - END -->