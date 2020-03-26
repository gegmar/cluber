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
                        <label>{{__('ticketshop.price')}}</label>
                        <input name="seats" type="text" step="1" min="0" required data-msg="Please enter seatmap's seats" class="form-control" value="{{ $seatmap->seats }}">
                    </div>
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
@endsection

@section('custom-js')

@endsection