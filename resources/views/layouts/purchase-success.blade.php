@extends('layouts.common')

@section('title', 'Ticketshop')

@section('page-title', 'Tickets')

@section('nav-link', route('laystart'))

@section('content')
<!---  Breadcrumb -->
<div class="breadcrumb-holder container-fluid">
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('laystart') }}">Back to Event overview</a></li>
        <li class="breadcrumb-item active">Download Tickets</li>
    </ul>
</div>
<section class="projects">
    <div class="container-fluid">
        <!-- Event-->
        <div class="project">
            <div class="row bg-white has-shadow">
                <div class="left-col col-lg-6 d-flex align-items-center justify-content-between">
                    <div class="project-title d-flex align-items-center">
                        <div class="text">
                            <h3 class="h4">Project Title</h3><small>Event Name</small>
                        </div>
                    </div>
                    <div class="project-date"><span class="hidden-sm-down">Friday, 21.01.2019</span></div>
                </div>
                <div class="right-col col-lg-6 d-flex align-items-center">
                    <div class="time"><i class="fa fa-clock-o"></i>12:00 PM </div>
                    <div class="comments"><i class="fa fa-map-marker"></i> NPZ Molln</div>
                </div>
            </div>
        </div>
        <!-- Customer Data and tickets -->
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <h3 class="h4">My Tickets</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Ticket type</th>
                                        <th>Number of tickets</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Standard</td>
                                        <td>4</td>
                                    </tr>
                                    <tr>
                                        <td>Reduced</td>
                                        <td>2</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <h3 class="h4">Customer data</h3>
                    </div>
                    <div class="card-body">
                        <p class="card-text">This information will be used to send your tickets via mail and track it
                            in our system (<a href="#">privacy terms</a>)</p>
                        <ul>
                            <li>E-Mail: mg@ge.com</li>
                            <li>Name: Martin</li>
                            <li>Newsletter subscription via mail: yes</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <h3 class="h4">Download Tickets</h3>
                    </div>
                    <div class="card-body">
                        <p class="card-text">Success! You can download your tickets here as pdf! Please bring them to
                            the event in order to enter the location.</p>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><a href="#">Tickets</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('custom-js')
<script type="text/javascript">
    $(document).ready(function() {

    });
</script>
@endsection