@inject('twitterService', 'App\Business\Services\TwitterService')
<div class="col-sm-3 col-xs-6">
    <div class="footer-widget footer-widget-twitter">
        <h4>@lang('layout.recent_tweets')</h4>
        <div id="twitter-wrapper">
            <ul class="list-unstyled">
                @foreach($twitterService->getLastsTweets() as $tweet)
                    <li>{{ $tweet->text }}</li>
                @endforeach
            </ul>
        </div>
    </div>
</div>