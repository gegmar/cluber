@extends('layouts.common')

@section('title', 'Ticketshop')

@section('page-title', __('ticketshop.events_and_projects'))

@section('nav-link', route('admin.events.dashboard'))

@section('content')
<!---  Breadcrumb -->
<div class="breadcrumb-holder container-fluid">
    <ul class="breadcrumb">
        <li class="breadcrumb-item active">{{__('ticketshop.events_and_projects')}}</li>
    </ul>
</div>

<!-- Events Section -->
<section class="no-padding-bottom">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h4>{{__('ticketshop.events')}}</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6" style="padding-bottom: 10px">
                        <button class="btn btn-primary" data-toggle="modal" data-target="#createEventModal"><i class="fa fa-plus"></i> {{__('ticketshop.new_event')}}</button>
                    </div>
                    <div class="col-lg-6">
                        <p></p>
                    </div>
                </div>
                <div class="table-responsive">
                    <table id="events" style="width: 100%;" class="table datatable">
                        <thead>
                            <tr>
                                <th>{{__('ticketshop.id')}}</th>
                                <th>{{__('ticketshop.project')}}</th>
                                <th>{{__('ticketshop.name')}}</th>
                                <th>{{__('ticketshop.Start')}}</th>
                                <th>{{__('ticketshop.actions')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($events as $event)
                            <tr>
                                <td>{{ $event->id }}</td>
                                <td>{{ $event->project->name }}</td>
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

<!-- Projects Section -->
<section class="no-padding-bottom">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6 col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>{{__('ticketshop.projects')}}</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <div class="row">
                                <div class="col-lg-6" style="padding-bottom: 10px">
                                    <button class="btn btn-primary" data-toggle="modal" data-target="#createProjectModal"><i class="fa fa-plus"></i> {{__('ticketshop.new_project')}}</button>
                                </div>
                                <div class="col-lg-6">
                                    <p></p>
                                </div>
                            </div>
                            <table id="projects" style="width: 100%;" class="table datatable">
                                <thead>
                                    <tr>
                                        <th>{{__('ticketshop.id')}}</th>
                                        <th>{{__('ticketshop.project')}}</th>
                                        <th>{{__('ticketshop.actions')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($projects as $project)
                                    <tr>
                                        <td>{{ $project->id }}</td>
                                        <td>{{ $project->name }}</td>
                                        <td>
                                            <a class="btn btn-primary" href="{{ route('admin.events.project.get', $project) }}"><i class="fa fa-edit"></i></a>
                                            <form style="display: inline" method="POST" action="{{ route('admin.events.project.archive', $project) }}">
                                                @csrf
                                                <button type="submit" class="btn btn-warning"><i class="fa fa-archive"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div> <!-- End projects card -->
            </div> <!-- End col-div -->
            <div class="col-lg-6 col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>{{__('ticketshop.archive')}}</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="archive" style="width: 100%;" class="table datatable">
                                <thead>
                                    <tr>
                                        <th>{{__('ticketshop.id')}}</th>
                                        <th>{{__('ticketshop.project')}}</th>
                                        <th>{{__('ticketshop.Start')}}</th>
                                        <th>{{__('ticketshop.end')}}</th>
                                        <th>{{__('ticketshop.actions')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($archived as $project)
                                    <tr>
                                        <td>{{ $project->id }}</td>
                                        <td>{{ $project->name }}</td>
                                        <td>{{ $project->start_date }}</td>
                                        <td>{{ $project->end_date }}</td>
                                        <td>
                                            <form method="POST" action="{{ route('admin.events.project.restore', $project) }}">
                                                @csrf
                                                <button type="submit" class="btn btn-success"><i class="fa fa-history"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div> <!-- End archive card -->
            </div> <!-- End col-div -->
        </div> <!-- End row-div -->
    </div>
</section>

<!-- Modals -->
<div class="modal fade" id="createProjectModal" tabindex="-1" role="dialog" aria-labelledby="createProjectModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('admin.events.project.create') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="createProjectModalLabel">{{__('ticketshop.new_project')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label class="col-sm-3 form-control-label">{{__('ticketshop.name')}}</label>
                        <div class="col-sm-9">
                            <input type="text" name="name" class="form-control" placeholder="Enter new project name" required="required"/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 form-control-label">{{__('ticketshop.description')}}</label>
                        <div class="col-sm-9">
                            <input type="text" name="description" class="form-control" placeholder="Enter description" required="required"/>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('ticketshop.cancel')}}</button>
                    <button type="submit" class="btn btn-primary">{{__('ticketshop.create')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="createEventModal" tabindex="-1" role="dialog" aria-labelledby="createEventModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('admin.events.create') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="createEventModalLabel">{{__('ticketshop.new_event')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label class="col-sm-3 form-control-label">{{__('ticketshop.name')}}</label>
                        <div class="col-sm-9">
                            <input type="text" name="name" class="form-control" placeholder="Enter new event name" required="required"/>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('ticketshop.cancel')}}</button>
                    <button type="submit" class="btn btn-primary">{{__('ticketshop.create')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>
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