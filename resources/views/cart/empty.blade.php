@extends('layouts.checkout')

@section('content')

@include('partials.breadcrumb')

<section class="content error">
    <div class="container">
        <div class="row">
            <div class="col-sm-8 col-sm-offset-2">
                <div class="error-wrapper">
                    <div class="error-number"><i class="fa {{ StaticVars::emptyCart()->random() }}"></i></div>
                    <div class="error-text">
                        <h1>Your cart is empty</h1>
                        <p>Better go buy something. Go back to <a href="{{ route('shop.catalogue') }}">Shopping</a></p>
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
@endsection