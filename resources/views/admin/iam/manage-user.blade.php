@extends('layouts.common')

@section('title', 'Ticketshop')

@section('page-title', __('ticketshop.iam'))

@section('nav-link', route('admin.iam.dashboard'))

@section('content')
<!---  Breadcrumb -->
<div class="breadcrumb-holder container-fluid">
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.iam.dashboard') }}">{{__('ticketshop.users_and_roles')}}</a></li>
        <li class="breadcrumb-item active">{{__('ticketshop.manage_user')}}</li>
    </ul>
</div>

<section class="no-padding-bottom">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h4>{{__('ticketshop.manage_user')}}</h4>
            </div>
            <div class="card-body">
                <form class="form-validate" action="{{ route('admin.iam.user.update', $user) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label>{{__('ticketshop.name')}}</label>
                        <input name="name" type="text" required data-msg="Please enter your name" class="form-control" value="{{ $user->name }}">
                    </div>
                    <div class="form-group">
                        <label>{{__('ticketshop.email')}}</label>
                        <input name="email" type="email" required data-msg="Please enter a valid email" class="form-control" value="{{ $user->email }}">
                    </div>
                    <div class="form-group">
                        <label>{{__('ticketshop.roles')}}</label>
                        <select class="selectable-multiple form-control" name="roles[]" multiple="multiple">
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}" @if( $user->roles->contains($role->id) ) selected="selected" @endif>{{ $role->name }}</option>
                        @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> {{__('ticketshop.save')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection

@section('custom-js')
<!-- Select2 JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('.selectable-multiple').select2();
    });
</script>
@endsection