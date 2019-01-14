@extends('layouts.common')

@section('title', 'Ticketshop')

@section('page-title', 'Tickets')

@section('nav-link', route('ts.events'))

@section('content')
<!---  Breadcrumb -->
<div class="breadcrumb-holder container-fluid">
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('start') }}">Events</a></li>
        <li class="breadcrumb-item active">Select Seats</li>
    </ul>
</div>
<?php
$prices = json_decode($event->priceList->prices);
?>
<section>
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h4>{{ $event->project->name }} | {{ $event->second_name }}</h4>
            </div>
            <div class="card-body">
                <p>Please select how many tickets you need (Price: <span id="price">0</span> <i class="fa fa-eur"></i>).</p>
                <form class="form-horizontal" action="{{ route('ts.setSeatMap', ['event' => $event->id]) }}" method="POST">
                    @csrf
                    @foreach( $prices as $label => $price)
                    <div class="form-group row">
                        <label class="col-sm-3 form-control-label">{{ $label }} ({{ $price }} <i class="fa fa-eur"></i>)</label>
                        <div class="col-sm-9">
                            <input type="text" name="tickets[{{ $label }}]" class="tickets form-control" data-price="{{ $price }}"
                                value="{{ $tickets[$label] }}">
                        </div>
                    </div>
                    @endforeach
                    <div class="form-group row justify-content-center">
                        <button type="submit" class="col-sm-2 btn btn-primary">Continue</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection

@section('custom-js')
<script src="/vendor/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js">
</script>
<script type="text/javascript">
    $(document).ready(function() {
        $(".tickets").TouchSpin({
            buttondown_class: 'btn btn-secondary',
            buttonup_class: 'btn btn-secondary',
            min: 0,
            max: 8,
            step: 1,
            decimals: 0,
        });

        function calculatePrice() {
            var price = 0;
            $('.tickets').each(function() {
                price += $(this).val() * $(this).data('price');
            });
            $('#price').html(price);
        }

        var prev_val;
        $(".tickets").focus(function() {
            prev_val = $(this).val();
        }).change(function() {
            $(this).blur();
            var sum = 0;
            $('.tickets').each(function() {
                sum += Number($(this).val());
            });
            if (sum > 8) {
                console.log(sum + "is too large")
                $(this).val(prev_val);
                return false;
            }

            calculatePrice();

            return true;
        });

        calculatePrice();
    });
</script>
@endsection