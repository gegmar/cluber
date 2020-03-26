@extends('layouts.common')

@section('title', 'Ticketshop')

@section('page-title', __('ticketshop.dependencies'))

@section('nav-link', route('admin.dependencies.dashboard'))

@section('content')
<!---  Breadcrumb -->
<div class="breadcrumb-holder container-fluid">
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dependencies.dashboard') }}">{{__('ticketshop.seatmaps_and_pricetables')}}</a></li>
        <li class="breadcrumb-item active">{{__('ticketshop.manage_price_category')}}</li>
    </ul>
</div>

<!-- Managing the price category -->
<section class="no-padding-bottom">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h4>{{__('ticketshop.manage_price_category')}}</h4>
            </div>
            <div class="card-body">
                <form class="form-validate" action="{{ route('admin.dependencies.prices.category.update', $category) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label>{{__('ticketshop.name')}}</label>
                        <input name="name" type="text" required data-msg="Please enter category's name" class="form-control" value="{{ $category->name }}">
                    </div>
                    <div class="form-group">
                        <label>{{__('ticketshop.description')}}</label>
                        <input name="description" type="text" required data-msg="Please enter category's description" class="form-control" value="{{ $category->description }}">
                    </div>
                    <div class="form-group">
                        <label>{{__('ticketshop.price')}}</label>
                        <input name="price" type="text" step="0.01" pattern="/[\d]{1-7}.[\d]{2}/" required data-msg="Please enter category's price" class="form-control" value="{{ $category->price }}">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> {{__('ticketshop.save')}}</button>
                    </div>
                </form>
                <hr/>
                <form style="display:inline-block" action="{{ route('admin.dependencies.prices.category.delete', [$category]) }}" method="POST">
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