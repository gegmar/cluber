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
            <div class="col-lg-6 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4>{{__('ticketshop.select_number_of_tickets')}} ({{__('ticketshop.price')}}: <span id="price">0</span> <i class="fa fa-eur"></i>)</h4>
                    </div>
                    <div class="card-body">
                        <form class="form-horizontal" action="{{ route('ts.setSeatMap', ['event' => $event->id]) }}" method="POST">
                            @csrf
                            @foreach( $event->priceList->categories()->orderBy('pivot_priority', 'ASC')->get() as $category)
                            <div class="form-group row">
                                <label class="col-sm-3 form-control-label">{{ $category->name }} ({{ $category->price }} <i class="fa fa-eur"></i>) @if($category->description)<i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="{{$category->description}}"></i>@endif</label>
                                <div class="col-sm-9">
                                    <input type="text" name="tickets[{{ $category->id }}]" class="tickets form-control" data-price="{{ $category->price }}"
                                        value="@if( $tickets !== null){{ $tickets[$category->id] }}@endif">
                                </div>
                            </div>
                            @endforeach
                            <div class="form-group row justify-content-center">
                                <button type="submit" class="col-sm-2 btn btn-primary">{{__('ticketshop.continue')}}</button>
                            </div>
                        </form>
                    </div>
                </div> <!-- end card -->
            </div> <!-- end col -->
            <div class="col-lg-6 col-sm-12">
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
            </div> <!-- end col -->
        </div> <!-- End row -->
        
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

        calculatePrice();

        return true;
    });

    calculatePrice();
});
</script>
@endsection