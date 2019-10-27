@extends('layouts.common')

@section('title', 'Ticketshop')

@section('page-title', __('ticketshop.events_and_projects'))

@section('nav-link', route('admin.events.dashboard'))

@section('content')
<!---  Breadcrumb -->
<div class="breadcrumb-holder container-fluid">
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.events.dashboard') }}">{{__('ticketshop.events_and_projects')}}</a></li>
        <li class="breadcrumb-item active">{{__('ticketshop.manage_event')}}</li>
    </ul>
</div>

<section class="no-padding-bottom">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h4>{{__('ticketshop.manage_event')}}</h4>
            </div>
            <div class="card-body">
                <form class="form-validate" action="@if($create){{ route('admin.events.create') }}@else{{ route('admin.events.update', $event) }}@endif" method="POST">
                    @csrf
                    <div class="form-group row">
                        <label class="col-sm-3 form-control-label">{{__('ticketshop.project')}}</label>
                        <select name="project" class="col-sm-9 selectable">
                            @if($create)<option selected>-</option>@endif
                            <optgroup label="{{__('ticketshop.projects')}}">
                            @foreach ($projects as $project)
                                <option @if(!$create && $event->project_id === $project->id) selected @endif value="{{ $project->id }}">{{ $project->name }}</option>
                            @endforeach
                            </optgroup>
                            <optgroup label="{{__('ticketshop.archive')}}">
                            @foreach ($archive as $project)
                                <option @if(!$create && $event->project_id === $project->id) selected @endif value="{{ $project->id }}">{{ $project->name }}</option>
                            @endforeach
                            </optgroup>
                        </select>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 form-control-label">{{__('ticketshop.name')}}</label>
                        <input name="name" type="text" required class="col-sm-9 form-control" value="@if(!$create){{ $event->second_name }}@endif">
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 form-control-label">{{__('ticketshop.Start')}}</label>
                        <input name="start" type="datetime" required class="col-sm-9 form-control" value="@if(!$create){{ $event->start_date }}@endif">
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 form-control-label">{{__('ticketshop.end')}}</label>
                        <input name="end" type="datetime" required class="col-sm-9 form-control" value="@if(!$create){{ $event->end_date }}@endif">
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 form-control-label">{{__('ticketshop.location')}}</label>
                        <select name="location" class="col-sm-9 selectable">
                            @if($create)<option selected>-</option>@endif
                        @foreach ($locations as $location)
                            <option @if(!$create && $event->location_id === $location->id) selected @endif value="{{ $location->id }}">{{ $location->name }}</option>
                        @endforeach
                        </select>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 form-control-label">{{__('ticketshop.seatmap')}}</label>
                        <select name="seatmap" class="col-sm-9 selectable">
                            @if($create)<option selected>-</option>@endif
                        @foreach ($seatmaps as $seatMap)
                            <option @if(!$create && $event->seat_map_id === $seatMap->id) selected @endif value="{{ $seatMap->id }}">{{ $seatMap->name }}</option>
                        @endforeach
                        </select>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 form-control-label">{{__('ticketshop.price_list')}}</label>
                        <select name="pricelist" class="col-sm-9 selectable">
                            @if($create)<option selected>-</option>@endif
                        @foreach ($pricelists as $priceList)
                            <option @if(!$create && $event->price_list_id === $priceList->id) selected @endif value="{{ $priceList->id }}">{{ $priceList->name }}</option>
                        @endforeach
                        </select>
                    </div>
                    <div class="form-group row">
                        <button type="submit" class="btn btn-primary col-sm-9 offset-sm-3"><i class="fa fa-save"></i> {{__('ticketshop.save')}}</button>
                    </div>
                    @if($create)
                    <div class="form-group row">
                        <a href="{{ route('admin.events.dashboard') }}" class="btn btn-secondary"><i class="fa fa-abort"></i> {{__('ticketshop.abort')}}</a>  
                    </div>
                    @endif
                </form>
                
                <hr>
                @if(!$create)
                <form style="display: inline" method="POST" action="{{ route('admin.events.delete', $event) }}">
                    @csrf
                    <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i> {{__('ticketshop.delete')}}</button>
                </form>
                @endif
            </div>
        </div>
    </div>
</section>

@endsection

@section('custom-js')
<!-- Select2 JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('.selectable').select2();
    });
</script>
@endsection