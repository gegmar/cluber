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
                <p>Please select your prefered seats.</p>
                <div class="sc-wrapper">
                    <div class="container sc-container">
                        <div id="seat-map">
                            <div class="sc-front-indicator">Front</div>

                        </div>
                        <div class="booking-details">
                            <h2>Booking Details</h2>

                            <h3> Selected Seats (<span id="counter">0</span>):</h3>
                            <ul id="selected-seats"></ul>

                            Total: <b>$<span id="total">0</span></b>

                            <button id="submit-seats" class="btn btn-primary checkout-button">Checkout &raquo;</button>

                            <div id="legend"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('custom-js')
<script type="text/javascript">
    var firstSeatLabel = 1;

    $(document).ready(function() {
        // docs @ https://github.com/mateuszmarkowski/jQuery-Seat-Charts
        var $cart = $('#selected-seats'),
            $counter = $('#counter'),
            $total = $('#total'),
            sc = $('#seat-map').seatCharts({
                map: [
                    'ff_ff',
                    'ff_ff',
                    'ee_ee',
                    'ee_ee',
                    'ee___',
                    'ee_ee',
                    'ee_ee',
                    'ee_ee',
                    'eeeee',
                ],
                seats: {
                    f: {
                        price: 100,
                        classes: 'first-class', //your custom CSS class
                        category: 'First Class'
                    },
                    e: {
                        price: 40,
                        classes: 'economy-class', //your custom CSS class
                        category: 'Economy Class'
                    }

                },
                naming: {
                    top: false,
                    getLabel: function(character, row, column) {
                        return firstSeatLabel++;
                    },
                },
                legend: {
                    node: $('#legend'),
                    items: [
                        ['f', 'available', 'First Class'],
                        ['e', 'available', 'Economy Class'],
                        ['f', 'unavailable', 'Already Booked']
                    ]
                },
                click: function() {
                    if (this.status() == 'available') {
                        //let's create a new <li> which we'll add to the cart items
                        $('<li>' + this.data().category + ' Seat # ' + this.settings.label + ': <b>$' +
                                this.data().price +
                                '</b> <a href="#" class="cancel-cart-item">[cancel]</a></li>')
                            .attr('id', 'cart-item-' + this.settings.id)
                            .data('seatId', this.settings.id)
                            .appendTo($cart);

                        /*
                         * Lets update the counter and total
                         *
                         * .find function will not find the current seat, because it will change its stauts only after return
                         * 'selected'. This is why we have to add 1 to the length and the current seat price to the total.
                         */
                        $counter.text(sc.find('selected').length + 1);
                        $total.text(recalculateTotal(sc) + this.data().price);

                        return 'selected';
                    } else if (this.status() == 'selected') {
                        //update the counter
                        $counter.text(sc.find('selected').length - 1);
                        //and total
                        $total.text(recalculateTotal(sc) - this.data().price);

                        //remove the item from our cart
                        $('#cart-item-' + this.settings.id).remove();

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

        //this will handle "[cancel]" link clicks
        $('#selected-seats').on('click', '.cancel-cart-item', function() {
            //let's just trigger Click event on the appropriate seat, so we don't have to repeat the logic here
            sc.get($(this).parents('li:first').data('seatId')).click();
        });

        $('#submit-seats').click(function() {
            var selectedSeats = [];
            sc.find('selected').each(function(seatId) {
                selectedSeats.push(this.node().attr('id'));
            });

            $.ajax({
                type: "GET",
                url: "{{ route('laycdata') }}",
                data: selectedSeats,
                success: function() {
                    location = "{{ route('laycdata') }}"
                }
            })
        });

        //let's pretend some seats have already been booked
        sc.get(['1_2', '4_1', '7_1', '7_2']).status('unavailable');
    });

    function recalculateTotal(sc) {
        var total = 0;

        //basically find every selected seat and sum its price
        sc.find('selected').each(function() {
            total += this.data().price;
        });

        return total;
    }
</script>
@endsection