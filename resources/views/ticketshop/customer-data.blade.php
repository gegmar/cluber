@extends('layouts.common')

@section('title', 'Ticketshop')

@section('page-title', __('ticketshop.tickets'))

@section('nav-link', route('ts.events'))

@section('content')
<!---  Breadcrumb -->
<div class="breadcrumb-holder container-fluid">
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('ts.events') }}">{{__('ticketshop.events')}}</a></li>
        <li class="breadcrumb-item"><a href="{{ route('ts.seatmap', ['event' => session('event')->id]) }}">{{__('ticketshop.Select_Seats')}}</a></li>
        <li class="breadcrumb-item active">{{__('ticketshop.customer_data')}}</li>
    </ul>
</div>
<section>
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h4>{{__('ticketshop.customer_data')}}</h4>
            </div>
            <div class="card-body">
                <p>{{__('ticketshop.customer_date_description')}}</p>
                <form class="form-validate" action="{{ route('ts.setCustomerData') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label>{{__('ticketshop.name')}}</label>
                        <input name="name" type="text" required data-msg="Please enter your name" class="form-control"
                            value="@if( array_key_exists('name', $data) ){{ $data['name'] }}@endif">
                    </div>
                    <div class="form-group">
                        <label>{{__('ticketshop.email')}}</label>
                        <input name="email" type="email" required data-msg="Please enter a valid email" class="form-control"
                            value="@if( array_key_exists('email', $data) ){{ $data['email'] }}@endif">
                    </div>
                    <div class="form-group">
                        <label>{{__('ticketshop.email_confirmation')}}</label>
                        <input name="email_confirmation" type="email" required data-msg="Please retype your email"
                            class="form-control" value="@if( array_key_exists('email', $data) ){{ $data['email'] }}@endif">
                    </div>
                    <div class="form-group">
                        <div>
                            <input id="check-terms" type="checkbox" name="terms" value="true" required="required" @if(
                                array_key_exists('terms', $data) )checked @endif>
                            <label for="check-terms">{{__('ticketshop.terms_agree')}}</label>
                        </div>
                        <div>
                            <input id="check-privacy" type="checkbox" name="privacy" value="true" required="required"
                                @if( array_key_exists('privacy', $data) )checked @endif>
                            <label for="check-privacy">{{__('ticketshop.privacy_agree')}}</label>
                        </div>
                        <div>
                            <input id="check-newsletter" type="checkbox" name="newsletter" value="true" @if(
                                array_key_exists('newsletter', $data) )checked @endif>
                            <label for="check-newsletter">{{__('ticketshop.newsletter_agree')}}</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">{{__('ticketshop.submit')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection

@section('custom-js')
<script type="text/javascript">
$(document).ready(function() {

});
</script>
@endsection