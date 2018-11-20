@extends('layouts.app')

@section('title', __('ticketshop.Events'))


@section('breadcrumbs')
<li class="breadcrumb-item"><a href="{{ route('start') }}">{{ __('ticketshop.Start') }}</a></li>
<li class="breadcrumb-item active" aria-current="page">{{ __('ticketshop.Select_Seats') }}</li>
@endsection

@section('content')
{{ json_encode($event) }}
@endsection