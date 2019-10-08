@extends('layouts.common')

@section('title', 'Ticketshop')

@section('page-title', __('ticketshop.settings'))

@section('nav-link', route('admin.settings.dashboard'))

@section('content')
<!---  Breadcrumb -->
<div class="breadcrumb-holder container-fluid">
    <ul class="breadcrumb">
        <li class="breadcrumb-item active">{{__('ticketshop.settings')}}</li>
    </ul>
</div>

<!-- Terms and Conditions Section -->
<section class="no-padding-bottom">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h4>{{__('ticketshop.terms')}}</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-xl-12">
                        <form method="POST" action="{{ route('admin.settings.update-terms') }}">
                            @csrf
                            <div class="form-group">
                                <textarea name="terms" class="summernote">{!! $terms !!}</textarea>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> {{__('ticketshop.save')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Privacy Section -->
<section class="no-padding-bottom">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h4>{{__('ticketshop.privacy')}}</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-xl-12">
                        <form method="POST" action="{{ route('admin.settings.update-privacy') }}">
                            @csrf
                            <div class="form-group">
                                <textarea name="privacy" class="summernote">{!! $privacy !!}</textarea>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> {{__('ticketshop.save')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Upload Logo Section -->
<section class="no-padding-bottom">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h4>{{__('ticketshop.logo')}}</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-xl-4">
                        <form id="logo-upload" action="{{ route('admin.settings.update-logo') }}" class="dropzone">
                            @csrf
                            <div class="dz-message">
                                <p>{{__('ticketshop.dropzone_explain')}}</p>
                            </div>
                            <div class="fallback">
                                <input name="file" type="file" multiple />
                            </div>
                        </form>
                    </div>
                    <div class="col-xl-4">
                        <img src="{{ route('logo') }}" />
                    </div>
                    <div class="col-xl-4">
                        <a class="btn btn-primary" href="{{ route('admin.settings.test-ticket') }}" target="_blank">{{__('ticketshop.test_ticket')}}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@section('custom-js')
<!-- Summernote-->
<script src="/vendor/summernote/summernote-bs4.min.js"></script>
<!-- Dropzone.js-->
<script src="/vendor/dropzone/min/dropzone.min.js"></script>
<script type="text/javascript">
    $('.summernote').summernote({
        height: 300
    });
</script>
@endsection