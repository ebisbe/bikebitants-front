@extends('layouts.checkout')

@section('content')
        <!-- ==========================
       ERROR - START
   =========================== -->
<section class="content error">
    <div class="container">
        <div class="row">
            <div class="col-sm-8 col-sm-offset-2">
                <div class="error-wrapper">
                    <div class="error-number">404</div>
                    <div class="error-text">
                        <h1>@lang('exceptions.page_not_found')</h1>
                        <p>@lang('exceptions.description')</p>
                        {{--<form>
                            <div class="input-group input-group-lg">
                                <input type="email" class="form-control" placeholder="Search ...">
                                    <span class="input-group-btn">
                                        <button class="btn btn-primary" type="button">Search</button>
                                    </span>
                            </div>
                        </form>--}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ==========================
    ERROR - END
=========================== -->
@endsection