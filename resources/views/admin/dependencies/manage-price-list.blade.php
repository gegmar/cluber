@extends('layouts.common')

@section('title', 'Ticketshop')

@section('page-title', __('ticketshop.dependencies'))

@section('nav-link', route('admin.dependencies.dashboard'))

@section('content')
<!---  Breadcrumb -->
<div class="breadcrumb-holder container-fluid">
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dependencies.dashboard') }}">{{__('ticketshop.seatmaps_and_pricetables')}}</a></li>
        <li class="breadcrumb-item active">{{__('ticketshop.manage_price_list')}}</li>
    </ul>
</div>

<!-- Managing the price list -->
<section class="no-padding-bottom">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h4>{{__('ticketshop.manage_price_list')}}</h4>
            </div>
            <div class="card-body">
                <form class="form-validate" action="{{ route('admin.dependencies.prices.list.update', $list) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label>{{__('ticketshop.name')}}</label>
                        <input name="name" type="text" required data-msg="Please enter price list's name" class="form-control" value="{{ $list->name }}">
                    </div>
                    <div class="form-group">
                        <label>{{__('ticketshop.categories')}}</label>
                        <select class="selectable-multiple form-control" name="categories[]" multiple="multiple">
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @if( $list->categories->contains($category->id) ) selected="selected" @endif>{{ $category->name }}</option>
                        @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> {{__('ticketshop.save')}}</button>
                    </div>
                </form>
                <hr/>
                <form style="display:inline-block" action="{{ route('admin.dependencies.prices.list.delete', [$list]) }}" method="POST">
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
<!-- Select2 JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>
<script src="/vendor/ladda/spin.min.js"></script>
<script src="/vendor/ladda/ladda.min.js"></script>
<script src="/js/components-ladda.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('.selectable-multiple').select2();
    });
    </script>
@endsection