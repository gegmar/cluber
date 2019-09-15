@extends('layouts.common')

@section('title', 'Ticketshop')

@section('page-title', __('ticketshop.iam'))

@section('nav-link', route('admin.iam.dashboard'))

@section('content')
<!---  Breadcrumb -->
<div class="breadcrumb-holder container-fluid">
    <ul class="breadcrumb">
        <li class="breadcrumb-item active">{{__('ticketshop.users_and_roles')}}</li>
    </ul>
</div>

<!-- Users Section -->
<section class="no-padding-bottom">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h4>{{__('ticketshop.users')}}</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="users" style="width: 100%;" class="table">
                        <thead>
                            <tr>
                                <th>{{__('ticketshop.id')}}</th>
                                <th>{{__('ticketshop.name')}}</th>
                                <th>{{__('ticketshop.email')}}</th>
                                <th>{{__('ticketshop.roles')}}</th>
                                <th>{{__('ticketshop.actions')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>@foreach ($user->roles as $role) <div class="badge badge-info">{{ $role->name }}</div> @endforeach</td>
                                <td><a class="btn btn-primary" href="{{ route('admin.iam.user.manage', $user) }}"><i class="fa fa-edit"></i></a></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Roles Section -->
<section>
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h4>{{__('ticketshop.roles')}}</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6" style="padding-bottom: 10px">
                        <button class="btn btn-primary" data-toggle="modal" data-target="#createRoleModal"><i class="fa fa-plus"></i> {{__('ticketshop.new_role')}}</button>
                    </div>
                    <div class="col-lg-6">
                        <p></p>
                    </div>
                </div>
                <div class="table-responsive">
                    <table id="roles" style="width: 100%;" class="table">
                        <thead>
                            <tr>
                                <th>{{__('ticketshop.id')}}</th>
                                <th>{{__('ticketshop.name')}}</th>
                                <th>{{__('ticketshop.number_of_users')}}</th>
                                <th>{{__('ticketshop.permissions')}}</th>
                                <th>{{__('ticketshop.actions')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($roles as $role)
                            <tr>
                                <td>{{ $role->id }}</td>
                                <td>{{ $role->name }}</td>
                                <td>{{ $role->users->count() }}</td>
                                <td>@foreach ($role->permissions as $permission) <div class="badge badge-info">{{ $permission->name }}</div> @endforeach</td>
                                <td><a class="btn btn-primary" href="{{ route('admin.iam.role.manage', $role) }}"><i class="fa fa-edit"></i></a></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modals -->
<div class="modal fade" id="createRoleModal" tabindex="-1" role="dialog" aria-labelledby="createRoleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('admin.iam.role.create') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="createRoleModalLabel">{{__('ticketshop.new_role')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label class="col-sm-3 form-control-label">{{__('ticketshop.name')}}</label>
                        <div class="col-sm-9">
                            <input type="text" name="name" class="form-control" placeholder="Enter new role name" required="required"/>
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
    var userDataTable = $('#users').DataTable({
        responsive: {
            details: false
        }
    });

    var roleDataTable = $('#roles').DataTable({
        responsive: {
            details: false
        }
    });

    $(document).on('sidebarChanged', function () {
        userDataTable.columns.adjust();
        userDataTable.responsive.recalc();
        userDataTable.responsive.rebuild();

        roleDataTable.columns.adjust();
        roleDataTable.responsive.recalc();
        roleDataTable.responsive.rebuild();
    });
});
</script>
@endsection