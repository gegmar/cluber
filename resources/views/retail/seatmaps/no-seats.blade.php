@extends('layouts.common')

@section('title', 'Ticketshop')

@section('page-title', 'Tickets')

@section('nav-link', route('retail.sell.events'))

@section('content')
<!---  Breadcrumb -->
<div class="breadcrumb-holder container-fluid">
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('retail.sell.events') }}">{{__('ticketshop.events')}}</a></li>
        <li class="breadcrumb-item active">{{__('ticketshop.Select_Seats')}}</li>
    </ul>
</div>
<section>
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h4>{{ $event->project->name }} | {{ $event->second_name }}</h4>
            </div>
            <div class="card-body">
                <p>{{__('ticketshop.select_number_of_tickets')}} ({{__('ticketshop.price')}}: <span id="price">0</span> <i class="fa fa-eur"></i>).</p>
                <form class="form-horizontal" action="{{ route('retail.sell.sell', ['event' => $event->id]) }}" method="POST">
                    @csrf
                    @foreach( $event->priceList->categories as $category)
                    <div class="form-group row">
                        <label class="col-sm-3 form-control-label">{{ $category->name }} ({{ $category->price }} <i class="fa fa-eur"></i>)</label>
                        <div class="col-sm-9">
                            <input type="text" name="tickets[{{ $category->name }}]" class="tickets form-control" data-price="{{ $category->price }}"
                                value="0">
                        </div>
                    </div>
                    @endforeach
                    <div class="form-group row justify-content-center">
                        <button type="submit" class="col-sm-2 btn btn-primary">{{__('ticketshop.sell')}}</button>
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
    var freeTickets = {{ $event->freeTickets() }};
    $(".tickets").TouchSpin({
        buttondown_class: 'btn btn-secondary',
        buttonup_class: 'btn btn-secondary',
        min: 0,
        max: freeTickets,
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
        if (sum > freeTickets) {
            $(this).val(prev_val);
            return false;
        }
        prev_val = $(this).val();

        calculatePrice();

        return true;
    });

    calculatePrice();
});
</script>
@endsection