@extends('layouts.common')

@section('title', 'Ticketshop')

@section('page-title', __('ticketshop.iam'))

@section('nav-link', route('admin.iam.dashboard'))

@section('content')
<!---  Breadcrumb -->
<div class="breadcrumb-holder container-fluid">
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.iam.dashboard') }}">{{__('ticketshop.users_and_roles')}}</a></li>
        <li class="breadcrumb-item active">{{__('ticketshop.manage_role')}}</li>
    </ul>
</div>

<!-- Managing the role -->
<section class="no-padding-bottom">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h4>{{__('ticketshop.manage_role')}}</h4>
            </div>
            <div class="card-body">
                <form class="form-validate" action="{{ route('admin.iam.role.update', $role) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label>{{__('ticketshop.name')}}</label>
                        <input name="name" type="text" required data-msg="Please enter role's name" class="form-control" value="{{ $role->name }}">
                    </div>
                    <div class="form-group">
                        <label>{{__('ticketshop.permissions')}}</label>
                        <select class="selectable-multiple form-control" name="permissions[]" multiple="multiple">
                        @foreach ($permissions as $permission)
                            <option value="{{ $permission->id }}" @if( $role->permissions->contains($permission->id) ) selected="selected" @endif>{{ $permission->name }}</option>
                        @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> {{__('ticketshop.save')}}</button>
                    </div>
                </form>
                <hr/>
                <form style="display:inline-block" action="{{ route('admin.iam.role.delete', [$role]) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger"><i class="fa fa-remove"></i> {{__('ticketshop.delete')}}</button>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- List of users attached to role -->
<section>
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h4>{{__('ticketshop.users_attached_to_role')}}</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6" style="padding-bottom: 10px">
                        <button class="btn btn-primary" data-toggle="modal" data-target="#addUserModal"><i class="fa fa-plus"></i> {{__('ticketshop.add_users')}}</button>
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
                                <th>{{__('ticketshop.email')}}</th>
                                <th>{{__('ticketshop.actions')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($role->users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    <form style="display:inline-block" action="{{ route('admin.iam.role.detach-user', ['role' => $role, 'user' => $user]) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-warning"><i class="fa fa-remove"></i></button>
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

<!-- Modals -->
<div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('admin.iam.role.attach-users', [$role]) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="addUserModalLabel">{{__('ticketshop.add_users')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label class="col-sm-3 form-control-label">{{__('ticketshop.users')}}</label>
                        <div class="col-sm-9">
                            <select class="selectable-multiple form-control" name="id[]" multiple="multiple">
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" @if( $role->users->contains($user->id) ) selected="selected" @endif>{{ $user->email }}</option>
                            @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('ticketshop.cancel')}}</button>
                    <button type="submit" class="btn btn-primary">{{__('ticketshop.add_users')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>
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