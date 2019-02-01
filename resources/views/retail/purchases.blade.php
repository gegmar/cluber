@extends('layouts.common')

@section('title', 'Ticketshop')

@section('page-title', 'Purchases')

@section('nav-link', route('retail.sold.tickets'))

@section('content')
<!---  Breadcrumb -->
<div class="breadcrumb-holder container-fluid">
    <ul class="breadcrumb">
        <li class="breadcrumb-item active">Sold Tickets</li>
    </ul>
</div>
<section>
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h4>Sales Overview</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6">
                        <p>These are your sales. Search and select them by the "search"-Field!</p>
                    </div>
                    <div class="col-lg-6">
                        <p></p>
                    </div>
                </div>
                <div class="table-responsive">
                    <table id="sales" style="width: 100%;" class="table">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Events</th>
                                <th>Customer</th>
                                <th>Number of Tickets</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($purchases as $purchase)
                            <tr>
                                <td>{{ $purchase->state_updated}}</td>
                                <td>@foreach( $purchase->events() as $event) {{ $event->project->name }} | {{ $event->second_name }} @endforeach</td>
                                <td>@if($purchase->customer) {{ $purchase->customer->name }} @elseif($purchase->customer_name) {{ $purchase->customer_name }} @else Shop Customer @endif</td>
                                <td>{{ $purchase->tickets->count() }}</td>
                                <td>
                                    <a href="{{ route('ticket.purchase', [$purchase->random_id]) }}" class="btn btn-default"><i class="fa fa-ticket"></i></a>
                                    <form style="display:inline-block" action="{{ route('retail.sold.delete', ['purchase' => $purchase]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('custom-js')
<!-- Data Tables-->
<script src="/vendor/datatables.net/js/jquery.dataTables.js"></script>
<script src="/vendor/datatables.net-bs4/js/dataTables.bootstrap4.js"></script>
<script src="/vendor/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="/vendor/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    var dataTable = $('#sales').DataTable({
        responsive: {
            details: false
        }
    }
    );

    $(document).on('sidebarChanged', function () {
        dataTable.columns.adjust();
        dataTable.responsive.recalc();
        dataTable.responsive.rebuild();
    });
});
</script>
@endsection