@extends('layouts.app')

@section('title', __('ticketshop.Events'))


@section('breadcrumbs')
<li class="breadcrumb-item"><a href="{{ route('start') }}">{{ __('ticketshop.Start') }}</a></li>
<li class="breadcrumb-item active" aria-current="page">{{ __('ticketshop.Select_Seats') }}</li>
@endsection

@section('content')
<div class="row py-4">
    <div class="progress col-12">
        <div class="progress-bar bg-success" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0"
            aria-valuemax="100">{{ __('ticketshop.Select_Seats') }}</div>
    </div>
</div>

@if( $event->seatMap === null )
<div class="row">
    <div class="col-12">
        <form>
            <div class="form-group row">
                <label for="inputNumberOfSeats" class="col-sm-2 col-form-label offset-sm-4">Number of tickets</label>
                <div class="col-sm-2">
                    <input type="number" class="form-control" id="inputNumberOfSeats" min=1 max=8 placeholder="Up to 8 tickets">
                </div>
            </div>

            <div class="form-group row">
                <div class="col-sm-2">
                    <button type="submit" class="btn btn-primary">Next</button>
                </div>
            </div>
        </form>
    </div>
</div>
@else
@component('seatmaps.' . $event->seatMap->name )

@endcomponent
@endif
@endsection