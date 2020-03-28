@extends('layouts.common')

@section('title', 'Ticketshop')

@section('page-title', __('ticketshop.dependencies'))

@section('nav-link', route('admin.dependencies.dashboard'))

@section('content')
<!---  Breadcrumb -->
<div class="breadcrumb-holder container-fluid">
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dependencies.dashboard') }}">{{__('ticketshop.seatmaps_and_pricetables')}}</a></li>
        <li class="breadcrumb-item active">{{__('ticketshop.manage_seatmap')}}</li>
    </ul>
</div>

<!-- Managing the seatmap -->
<section class="no-padding-bottom">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h4>{{__('ticketshop.manage_seatmap')}}</h4>
            </div>
            <div class="card-body">
                <form class="form-validate" action="{{ route('admin.dependencies.seatmap.update', $seatmap) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label>{{__('ticketshop.name')}}</label>
                        <input name="name" type="text" required data-msg="Please enter seatmap's name" class="form-control" value="{{ $seatmap->name }}">
                    </div>
                    <div class="form-group">
                        <label>{{__('ticketshop.description')}}</label>
                        <input name="description" type="text" required data-msg="Please enter seatmap's description" class="form-control" value="{{ $seatmap->description }}">
                    </div>
                    <div class="form-group">
                        <label>{{__('ticketshop.seats')}}</label>
                        <input id="layout-seats" name="seats" type="text" step="1" min="0" required data-msg="Please enter seatmap's seats" class="form-control" value="{{ $seatmap->seats }}">
                    </div>
                    <div class="form-group">
                        <label>{{__('ticketshop.seatmap_has_layout')}}</label>
                        <input id="layout-switch" type="checkbox" @if($seatmap->layout) checked @endif>
                    </div>
                    <input id="layout-submit" type="hidden" name="layout" value="@if($seatmap->layout) {{$seatmap->layout}} @endif">
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> {{__('ticketshop.save')}}</button>
                    </div>
                </form>
                <hr/>
                <form style="display:inline-block" action="{{ route('admin.dependencies.seatmap.delete', [$seatmap]) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger"><i class="fa fa-remove"></i> {{__('ticketshop.delete')}}</button>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- Layout Section -->
<section class="no-padding-bottom @if(!$seatmap->layout) hidden @endif" id="layout">
    <div class="container-fluid">
        <div class="row">
            <!-- Input column -->
            <div class="col-lg-6 col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>{{__('ticketshop.layout_input')}}</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <p>{{__('ticketshop.layout_explanation')}}</p>
                        </div>
                        <div class="form-group">
                            @php
                                $textareaContent = "";
                                if( $seatmap->layout ) {
                                    $textareaContent = implode("\n", json_decode($seatmap->layout));
                                }
                            @endphp
                            <textarea id="layout-input" rows="7" cols="40" placeholder="aaaaaaa___aaaaa&#10;aaaaaaa___aaaaa&#10;aaaaaaa___aaaaa">{{ $textareaContent }}</textarea>
                        </div>
                    </div>
                </div> <!-- End card -->
            </div> <!-- End Input col-div -->

            <!-- Output column -->
            <div class="col-lg-6 col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>{{__('ticketshop.layout_output')}}</h4>
                    </div>
                    <div class="card-body">
                        <div class="sc-wrapper">
                            <div class="sc-container" id="seat-container">
                                <div id="seat-map">
                                    <div class="sc-front-indicator">{{__('ticketshop.stage')}}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- End card -->
            </div> <!-- End Output col-div -->
        </div> <!-- End row-div -->
    </div>
</section>
@endsection

@section('custom-js')
<script type="text/javascript">
    function update() {
        var firstSeatLabel = 1;
        var rowCounter = 0;
        var columnCounter = 1;
        var maxColumnTracker = 5;
        var undefinesCounter = 0;
        var maxUndefinesTracker = 0;

        // Prepare the textarea-value for processing as js-array in the SeatChart
        var input = $('#layout-input').val();
        // Split the input into an array with each textarea row as element
        toProcess = input.split("\n");
        // trim each row to prevent leading or trailing whitespaces
        toProcess = toProcess.map(function(element) {
            return element.trim();
        });
        // set array as value for submission to server in json-format '["aaa__aaa", "aaaaaaaa_a", ...]'
        toProcessJsons = JSON.stringify(toProcess);
        $('#layout-submit').val(toProcessJsons);
        // set number of seats according to the appearance of 'a's in the json-string
        // @see https://stackoverflow.com/questions/881085/count-the-number-of-occurrences-of-a-character-in-a-string-in-javascript
        count = (toProcessJsons.match(/a/g)||[]).length;
        $('#layout-seats').val(count);

        $('#seat-container').html('<div id="seat-map"><div class="sc-front-indicator">{{__('ticketshop.stage')}}</div></div>');

        // docs @ https://github.com/mateuszmarkowski/jQuery-Seat-Charts
        var sc = $('#seat-map').seatCharts({
            map: toProcess, 
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
                    if(row > rowCounter) { // reset counter in a new row
                        columnCounter = 0;
                        undefinesCounter = 0;
                        rowCounter = row;
                    }
                    if(character == 'a') {
                        columnCounter++;
                    }
                    if(!column) { // happens if column is undefined due to exceed the columns of the first row
                        undefinesCounter++;
                    }
                    if(undefinesCounter > maxUndefinesTracker) {
                        maxUndefinesTracker = undefinesCounter;
                        $('#seat-container').css('width', 50 + 40*maxColumnTracker + 40*maxUndefinesTracker);
                    }
                    if(column > maxColumnTracker) {
                        maxColumnTracker = column;
                        $('#seat-container').css('width', 50 + 40*maxColumnTracker + 40*maxUndefinesTracker);
                    }
                    return columnCounter;
                },
                getId: function(character, row, column) {
                    return firstSeatLabel++;
                }
            },
            legend: {
                node: $('#legend'),
            },
            click: function() {
                if (this.status() == 'available') {
                    return 'selected';
                } else if (this.status() == 'selected') {
                    return 'available';
                } else if (this.status() == 'unavailable') {
                    return 'unavailable';
                } else {
                    return this.style();
                }
            }
        });
    }
    @if($seatmap->layout) update(); @endif
    $('#layout-input').change(update);
    $('#layout-input').keyup(update);

    $('#layout-switch').change(function() {
        if( $(this).is(':checked') ) {
            $('#layout').removeClass('hidden');
            update();
        } else {
            $('#layout').addClass('hidden');
            $('#layout-submit').val('');
        }
        
    });
</script>
@endsection