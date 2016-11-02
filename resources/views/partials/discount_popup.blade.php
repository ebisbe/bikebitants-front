<!-- ==========================
    	MODAL ADVERTISING  - START
    =========================== -->
<div class="modal fade" tabindex="-1" role="dialog" id="modalAdvertising">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="fa fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-8">
                        <h3>@lang('popup_header.h3')</h3>
                        <p>@lang('popup_header.p')</p>
                        <form method="POST" action="/lead/" id="js-popup">
                            <div class="input-group">
                                {{ csrf_field() }}
                                <input type="email" name="email" class="form-control"
                                       placeholder="@lang('popup_header.email_placeholder')">
                                <input type="hidden" name="type" value="popup">
                                    <span class="input-group-btn">
                                        <button class="btn btn-primary js-popup-send" type="submit">
                                            <i></i>@lang('popup_header.submit')
                                        </button>
                                    </span>
                            </div>
                            <span class="js-popup-message"></span>
                        </form>
                        <div class="checkbox">
                            <input id="modal-hide" type="checkbox" value="hidden">
                            <label for="modal-hide">@lang('popup_header.dont_show_again')</label>
                        </div>
                    </div>
                    <div class="col-sm-4 hidden-xs">
                        <img src="/img/174/Closa-fuga-black-foldable-helmet-02-big.png" class="img-responsive" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ==========================
    MODAL ADVERTISING - END
=========================== -->