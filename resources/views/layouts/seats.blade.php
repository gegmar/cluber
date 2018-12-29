@extends('layouts.common')

@section('title', 'Ticketshop')

@section('page-title', 'Tickets')

@section('nav-link', route('laystart'))

@section('content')
<!---  Breadcrumb -->
<div class="breadcrumb-holder container-fluid">
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('laystart') }}">Events</a></li>
        <li class="breadcrumb-item active">Select Seats</li>
    </ul>
</div>
<section>
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h4>4. Aufführung Verteidigung von Molln</h4>
            </div>
            <div class="card-body">
                <p>Please select how many tickets you need (Price: <span id="price">0</span> <i class="fa fa-eur"></i>).</p>
                <form class="form-horizontal" action="{{ route('laycdata') }}" method="GET">
                    <div class="form-group row">
                        <label class="col-sm-3 form-control-label">Number of tickets</label>
                        <div class="col-sm-9">
                            <input type="text" name="standard-tickets" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 form-control-label">Number of tickets</label>
                        <div class="col-sm-9">
                            <input type="text" name="reduced-tickets" class="form-control">
                        </div>
                    </div>
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
        var normalPrice = 15;
        var reducedPrice = 8;
        var reducedTickets = $("input[name='reduced-tickets']");
        var normalTickets = $("input[name='standard-tickets']");
        reducedTickets.TouchSpin({
            buttondown_class: 'btn btn-secondary',
            buttonup_class: 'btn btn-secondary',
            min: 0,
            max: 8,
            step: 1,
            decimals: 0,
        });
        normalTickets.TouchSpin({
            buttondown_class: 'btn btn-secondary',
            buttonup_class: 'btn btn-secondary',
            min: 0,
            max: 8,
            step: 1,
            decimals: 0,
        });

        function calcPrice() {
            var price = normalTickets.val() * normalPrice + reducedTickets.val() * reducedPrice;
            $('#price').html(price);
        }

        reducedTickets.change(calcPrice);
        normalTickets.change(calcPrice);
    });
</script>
@endsection