@extends('layouts.common')

@section('title', 'Ticketshop')

@section('page-title', __('ticketshop.tickets'))

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
                <form id="ticket-form" class="form-horizontal" action="{{ route('retail.sell.sell', ['event' => $event->id]) }}" method="POST">
                    @csrf
                    @foreach( $event->priceList->categories as $category)
                    <div class="form-group row">
                        <label class="col-sm-3 form-control-label">{{ $category->name }} ({{ $category->price }} <i class="fa fa-eur"></i>) @if($category->description)<i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="{{$category->description}}"></i>@endif</label>
                        <div class="col-sm-9">
                            <input type="text" name="tickets[{{ $category->id }}]" class="tickets form-control" data-price="{{ $category->price }}"
                                value="0">
                        </div>
                    </div>
                    @endforeach
                    <div class="form-group justify-content-center">
                        <button type="submit" class="btn btn-primary">{{__('ticketshop.sell')}}</button>
                        @if(Auth::user()->hasPermission('RESERVE_TICKETS'))
                        <button type="button" class="btn btn-outline-primary submitters" data-toggle="modal" data-target="#reserveModal">{{__('ticketshop.reserve')}}</button>
                        @endif
                        @if(Auth::user()->hasPermission('HANDLING_FREE_TICKETS'))
                        <button type="button" class="btn btn-warning submitters" data-toggle="modal" data-target="#freeModal">{{__('ticketshop.free-tickets')}}</button>
                        @endif
                    </div>
                    
                    <input type="hidden" name="action" value="paid" />
                </form>
            </div>
        </div>
    </div>
    <!-- Modal:ReserveTickets -->
    <div class="modal fade" id="reserveModal" tabindex="-1" role="dialog" aria-labelledby="reserveModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="reserveModalLabel">{{__('ticketshop.customer_data')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="{{__('ticketshop.cancel')}}">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="reservation-form">
                        <div class="form-group row">
                            <label class="col-sm-3 form-control-label">{{__('ticketshop.customer')}}</label>
                            <div class="col-sm-9">
                                <input type="text" name="customer-name" class="form-control" value="" required>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('ticketshop.cancel')}}</button>
                    <button id="submit-reservation" type="button" class="btn btn-outline-primary">{{__('ticketshop.reserve')}}</button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Modal:FreeTickets -->
    <div class="modal fade" id="freeModal" tabindex="-1" role="dialog" aria-labelledby="freeModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="freeModalLabel">{{__('ticketshop.customer_data')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="{{__('ticketshop.cancel')}}">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="free-form">
                        <div class="form-group row">
                            <label class="col-sm-3 form-control-label">{{__('ticketshop.customer')}}</label>
                            <div class="col-sm-9">
                                <input type="text" name="customer-name" class="form-control" value="" required>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('ticketshop.cancel')}}</button>
                    <button id="submit-free" type="button" class="btn btn-warning">{{__('ticketshop.free-tickets')}}</button>
                </div>
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

    $('#submit-reservation').click(function(){
        $('#ticket-form').append($('#reservation-form').find('input[name="customer-name"]'));
        $('#ticket-form').find('input[name="action"]').val('reserved');
        $('#ticket-form').submit();
    });

    $('#submit-free').click(function(){
        $('#ticket-form').append($('#free-form').find('input[name="customer-name"]'));
        $('#ticket-form').find('input[name="action"]').val('free');
        $('#ticket-form').submit();
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