@extends('layouts.common')

@section('title', 'Ticketshop')

@section('page-title', __('ticketshop.tickets'))

@section('nav-link', route('ts.events'))

@section('content')
<!---  Breadcrumb -->
<div class="breadcrumb-holder container-fluid">
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('start') }}">{{__('ticketshop.events')}}</a></li>
        <li class="breadcrumb-item active">{{__('ticketshop.Select_Seats')}}</li>
    </ul>
</div>
<section>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h4>{{__('ticketshop.selected_event')}}</h4>
                    </div>
                    <div class="card-body">
                        <h5>{{ $event->project->name }}</h5>
                        <h6 class="card-title">{{ $event->second_name }}</h6>
                        <p class="card-text"><i class="fa fa-calendar"></i> @datetime($event->start_date)</p>
                        <p class="card-text"><i class="fa fa-clock-o"></i> @time($event->start_date)</p>
                    </div>
                </div> <!-- end card -->
                <div class="card">
                    <div class="card-header">
                        <h4>{{__('ticketshop.price-category')}}</h4>
                    </div>
                    <div class="card-body">
                        <p>{{__('ticketshop.select_number_of_tickets')}} ({{__('ticketshop.price')}}: <span id="price">0</span> <i class="fa fa-eur"></i>).</p>
                        <form id="seats_form" class="form-horizontal" action="{{ route('ts.setSeatMap', ['event' => $event->id]) }}" method="POST">
                            @csrf
                            @foreach( $event->priceList->categories as $category)
                            <div class="form-group row">
                                <label class="col-sm-6 form-control-label">{{ $category->name }} ({{ $category->price }} <i class="fa fa-eur"></i>) @if($category->description)<i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="{{$category->description}}"></i>@endif</label>
                                <div class="col-sm-6">
                                    <input type="text" name="tickets[{{ $category->id }}]" class="tickets form-control" data-price="{{ $category->price }}"
                                        value="@if( $tickets !== null){{ $tickets[$category->id] }}@endif">
                                </div>
                            </div>
                            @endforeach
                            <div class="form-group justify-content-center">
                                <button id="submit-button" type="submit" class="btn btn-primary" disabled>{{__('ticketshop.continue')}}</button>
                            </div>
                        </form>
                    </div>
                </div> <!-- end card -->
            </div> <!-- end col -->
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h4>{{__('ticketshop.Select_Seats')}} | <span id="selected-seats-count">0</span> / <span id="selected-persons-count">0</span></h4>
                    </div>
                    <div class="card-body">
                        <div class="sc-wrapper">
                            <div class="sc-container">
                                <div id="seat-map">
                                    <div class="sc-front-indicator">{{__('ticketshop.stage')}}</div>
                                </div>
                                <div class="booking-details">
                                    <div id="legend"></div>
                                </div>
                            </div>
                        </div>
                    </div>
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
    var firstSeatLabel = 1;
    var freeTickets = {{ $event->freeTickets() }};
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

    function updateButtonState() {
        if( $('#selected-seats-count').html() != 0 &&
            $('#selected-seats-count').html() == $('#selected-persons-count').html() ) {
            $('#submit-button').prop('disabled', false);
        } else {
            $('#submit-button').attr('disabled', true);
        }
    }

    function updateSelectedSeatsCount(amount) {
        total = parseInt($('#selected-seats-count').html());
        total += amount;
        $('#selected-seats-count').html(total);
        updateButtonState();
    }

    var prev_val;
    // Also preserve state when the value gets changed by the touchspin buttons
    $(".bootstrap-touchspin-up").click(function(){
        // 1.Parent = span-element, 2.Parent = div-element containing the two touchspin-span-buttons and the actual input-element
        prev_val = $(this).parent().parent().children("input.tickets").val();
    });
    $(".bootstrap-touchspin-down").click(function(){
        // 1.Parent = span-element, 2.Parent = div-element containing the two touchspin-span-buttons and the actual input-element
        prev_val = $(this).parent().parent().children("input.tickets").val();
    });
    
    $(".tickets").focus(function() {
        prev_val = $(this).val();
    }).change(function() {
        $(this).blur();
        var sum = 0;
        $('.tickets').each(function() {
            sum += Number($(this).val());
        });
        if (sum > 8 || sum > freeTickets) {
            $(this).val(prev_val);
            return false;
        }

        $('#selected-persons-count').html(sum);
        calculatePrice();
        updateButtonState();

        return true;
    });

    // docs @ https://github.com/mateuszmarkowski/jQuery-Seat-Charts
    var sc = $('#seat-map').seatCharts({
        map: [
            {!! $event->seatMap->layout !!}
        ], 
        seats: {
            a: {
                price: 100,
                classes: 'first-class', //your custom CSS class
                category: 'First Class'
            },

        },
        naming: {
            top: false,
            getLabel: function(character, row, column) {
                return 19 - column;
            },
            getId: function(character, row, column) {
                return firstSeatLabel++;
            }
        },
        legend: {
            node: $('#legend'),
            items: [
                ['a', 'available', "{{__('ticketshop.free')}}"],
                ['a', 'selected', "{{__('ticketshop.selected')}}"],
                ['a', 'unavailable', "{{__('ticketshop.booked')}}"]
            ]
        },
        click: function() {
            if (this.status() == 'available') {
                // Do not allow more than 8 selected seats
                if( parseInt($('#selected-seats-count').html()) >= 8 ) {
                    return 'available';
                }

                //let's create a new <input> which we'll add to the form
                seatId = this.settings.id;
                $('#seats_form').append('<input type="hidden" id="input-selected-seat-' + seatId + '" name="selected-seats[]" value="' + seatId + '" />');
                updateSelectedSeatsCount(1);

                return 'selected';
            } else if (this.status() == 'selected') {
                // remove the input from the form
                seatId = this.settings.id;
                $('#input-selected-seat-' + seatId).remove();
                updateSelectedSeatsCount(-1);
                //seat has been vacated
                return 'available';
            } else if (this.status() == 'unavailable') {
                //seat has been already booked
                return 'unavailable';
            } else {
                return this.style();
            }
        }
    });

    // Set booked seats as unavailable
    var bookedSeats = {{ json_encode( $event->tickets()->pluck('seat_number')->toArray() ) }};
    sc.get(bookedSeats).status('unavailable');

    calculatePrice();
});
</script>
@endsection