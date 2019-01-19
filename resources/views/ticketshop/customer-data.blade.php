@extends('layouts.common')

@section('title', 'Ticketshop')

@section('page-title', 'Tickets')

@section('nav-link', route('ts.events'))

@section('content')
<!---  Breadcrumb -->
<div class="breadcrumb-holder container-fluid">
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('ts.events') }}">Events</a></li>
        <li class="breadcrumb-item"><a href="{{ route('ts.seatmap', ['event' => session('event')->id]) }}">Select Seats</a></li>
        <li class="breadcrumb-item active">Customer Data</li>
    </ul>
</div>
<section>
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h4>Customer Data</h4>
            </div>
            <div class="card-body">
                <p>Please add your information to our purchase in order to receive your tickets later via e-mail and
                    mark them as your own. Also you can agree to get our newsletter.</p>
                <form class="form-validate" action="{{ route('ts.setCustomerData') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label>Name</label>
                        <input name="name" type="text" required data-msg="Please enter your name" class="form-control"
                            value="@if( array_key_exists('name', $data) ){{ $data['name'] }}@endif">
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input name="email" type="email" required data-msg="Please enter a valid email" class="form-control"
                            value="@if( array_key_exists('email', $data) ){{ $data['email'] }}@endif">
                    </div>
                    <div class="form-group">
                        <label>Confirm Email</label>
                        <input name="email_confirmation" type="email" required data-msg="Please retype your email"
                            class="form-control" value="@if( array_key_exists('email', $data) ){{ $data['email'] }}@endif">
                    </div>
                    <div class="form-group">
                        <div>
                            <input id="check-terms" type="checkbox" name="terms" value="true" required="required" @if(
                                array_key_exists('terms', $data) )checked @endif>
                            <label for="check-terms">I agree to the Terms and Conditions of this online shop.</label>
                        </div>
                        <div>
                            <input id="check-privacy" type="checkbox" name="privacy" value="true" required="required"
                                @if( array_key_exists('privacy', $data) )checked @endif>
                            <label for="check-privacy">I agree that my data is processed as it is stated in the privacy
                                section.</label>
                        </div>
                        <div>
                            <input id="check-newsletter" type="checkbox" name="newsletter" value="true" @if(
                                array_key_exists('newsletter', $data) )checked @endif>
                            <label for="check-newsletter">I would like to receive the newsletter.</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Submit</button>
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