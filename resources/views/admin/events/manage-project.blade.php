@extends('layouts.common')

@section('title', 'Ticketshop')

@section('page-title', __('ticketshop.events_and_projects'))

@section('nav-link', route('admin.events.dashboard'))

@section('content')
<!---  Breadcrumb -->
<div class="breadcrumb-holder container-fluid">
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.events.dashboard') }}">{{__('ticketshop.events_and_projects')}}</a></li>
        <li class="breadcrumb-item active">{{__('ticketshop.manage_project')}}</li>
    </ul>
</div>

<section class="no-padding-bottom">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h4>{{__('ticketshop.manage_project')}}</h4>
            </div>
            <div class="card-body">
                <form class="form-validate" action="{{ route('admin.iam.user.update', $project) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label>{{__('ticketshop.name')}}</label>
                        <input name="name" type="text" required class="form-control" value="{{ $project->name }}">
                    </div>
                    <div class="form-group">
                        <label>{{__('ticketshop.description')}}</label>
                        <input name="description" type="text" required class="form-control" value="{{ $project->description }}">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> {{__('ticketshop.save')}}</button>
                    </div>
                </form>
                <hr>
                <form style="display: inline" method="POST" action="{{ route('admin.events.project.archive', $project) }}">
                    @csrf
                    <button type="submit" class="btn btn-warning"><i class="fa fa-archive"></i> {{__('ticketshop.archiving')}}</button>
                </form>
                <form style="display: inline" method="POST" action="{{ route('admin.events.project.delete', $project) }}">
                    @csrf
                    <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i> {{__('ticketshop.delete')}}</button>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- Events Section -->
<section class="no-padding-bottom">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h4>{{__('ticketshop.events')}}</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="events" style="width: 100%;" class="table datatable">
                        <thead>
                            <tr>
                                <th>{{__('ticketshop.id')}}</th>
                                <th>{{__('ticketshop.name')}}</th>
                                <th>{{__('ticketshop.Start')}}</th>
                                <th>{{__('ticketshop.actions')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($project->events as $event)
                            <tr>
                                <td>{{ $event->id }}</td>
                                <td>{{ $event->second_name }}</td>
                                <td>{{ $event->start_date }}</td>
                                <td><a class="btn btn-primary" href="{{ route('admin.events.get', $event) }}"><i class="fa fa-edit"></i></a></td>
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
    $('.datatable').DataTable({
        responsive: {
            details: false
        }
    });
});
</script>
@endsection