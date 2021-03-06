@extends('layouts.common')

@section('title', 'Ticketshop')

@section('page-title', __('ticketshop.terms'))

@section('content')
<!---  Breadcrumb -->
<div class="breadcrumb-holder container-fluid">
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('start') }}">{{__('ticketshop.back_to_start')}}</a></li>
    </ul>
</div>
<section>
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h4>{{__('ticketshop.terms')}}</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                        {!! $terms !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection