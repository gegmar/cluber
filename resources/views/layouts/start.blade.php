@extends('layouts.common')

@section('title', 'Ticketshop')

@section('page-title', 'Tickets')

@section('nav-link', route('laystart'))

@section('content')
<!---  Breadcrumb -->
<div class="breadcrumb-holder container-fluid">
    <ul class="breadcrumb">
        <li class="breadcrumb-item">Events</li>
    </ul>
</div>
<section>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">Verteidigung von Molln</div>
                    <div class="card-body">
                        <h4 class="card-title">3. Aufführung</h4>
                        <p class="card-text">Friday, 21.12.2018</p><a href="{{ route('layseatmap') }}" class="btn btn-primary">Buy
                            Tickets</a>
                    </div>
                    <div class="card-footer text-muted">Still tickets available</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">Verteidigung von Molln</div>
                    <div class="card-body">
                        <h4 class="card-title">4. Aufführung</h4>
                        <p class="card-text">Saturday, 22.12.2018</p><a href="{{ route('layseatmap') }}" class="btn btn-primary disabled">Buy
                            Tickets</a>
                    </div>
                    <div class="card-footer text-muted">Sold out</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">Verteidigung von Molln</div>
                    <div class="card-body">
                        <h4 class="card-title">Derniére</h4>
                        <p class="card-text">Sunday, 23.12.2018</p><a href="{{ route('layseatmap') }}" class="btn btn-primary">Buy
                            Tickets</a>
                    </div>
                    <div class="card-footer text-muted">Still tickets available</div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">Verteidigung von Molln</div>
                    <div class="card-body">
                        <h4 class="card-title">3. Aufführung</h4>
                        <p class="card-text">Friday, 21.12.2018</p><a href="{{ route('layseatmap') }}" class="btn btn-primary">Buy
                            Tickets</a>
                    </div>
                    <div class="card-footer text-muted">Still tickets available</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">Verteidigung von Molln</div>
                    <div class="card-body">
                        <h4 class="card-title">4. Aufführung</h4>
                        <p class="card-text">Saturday, 22.12.2018</p><a href="{{ route('layseatmap') }}" class="btn btn-primary disabled">Buy
                            Tickets</a>
                    </div>
                    <div class="card-footer text-muted">Sold out</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">Verteidigung von Molln</div>
                    <div class="card-body">
                        <h4 class="card-title">Derniére</h4>
                        <p class="card-text">Sunday, 23.12.2018</p><a href="{{ route('layseatmap') }}" class="btn btn-primary">Buy
                            Tickets</a>
                    </div>
                    <div class="card-footer text-muted">Still tickets available</div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">Verteidigung von Molln</div>
                    <div class="card-body">
                        <h4 class="card-title">3. Aufführung</h4>
                        <p class="card-text">Friday, 21.12.2018</p><a href="{{ route('layseatmap') }}" class="btn btn-primary">Buy
                            Tickets</a>
                    </div>
                    <div class="card-footer text-muted">Still tickets available</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">Verteidigung von Molln</div>
                    <div class="card-body">
                        <h4 class="card-title">4. Aufführung</h4>
                        <p class="card-text">Saturday, 22.12.2018</p><a href="{{ route('layseatmap') }}" class="btn btn-primary disabled">Buy
                            Tickets</a>
                    </div>
                    <div class="card-footer text-muted">Sold out</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">Verteidigung von Molln</div>
                    <div class="card-body">
                        <h4 class="card-title">Derniére</h4>
                        <p class="card-text">Sunday, 23.12.2018</p><a href="{{ route('layseatmap') }}" class="btn btn-primary">Buy
                            Tickets</a>
                    </div>
                    <div class="card-footer text-muted">Still tickets available</div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection