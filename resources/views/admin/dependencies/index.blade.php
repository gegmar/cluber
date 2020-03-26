@extends('layouts.common')

@section('title', 'Ticketshop')

@section('page-title', __('ticketshop.dependencies'))

@section('nav-link', route('admin.dependencies.dashboard'))

@section('content')
<!---  Breadcrumb -->
<div class="breadcrumb-holder container-fluid">
    <ul class="breadcrumb">
        <li class="breadcrumb-item active">{{__('ticketshop.seatmaps_and_pricetables')}}</li>
    </ul>
</div>

<!-- SeatMaps Section -->
<section class="no-padding-bottom">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h4>{{__('ticketshop.seatmaps')}}</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6" style="padding-bottom: 10px">
                        <a href="{{ route('admin.dependencies.seatmap.show-create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> {{__('ticketshop.new_seatmap')}}</a>
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
                                <th>{{__('ticketshop.name')}}</th>
                                <th>{{__('ticketshop.description')}}</th>
                                <th>{{__('ticketshop.seats')}}</th>
                                <th>{{__('ticketshop.has_map')}}</th>
                                <th>{{__('ticketshop.actions')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($seatmaps as $seatMap)
                            <tr>
                                <td>{{ $seatMap->id }}</td>
                                <td>{{ $seatMap->name }}</td>
                                <td>{{ $seatMap->description }}</td>
                                <td>{{ $seatMap->seats }}</td>
                                <td>@if($seatMap->layout) <i class="fa fa-check-circle-o"></i> @else <i class="fa fa-circle-o"></i> @endif</td>
                                <td><a class="btn btn-primary" href="{{ route('admin.dependencies.seatmap.get', $seatMap) }}"><i class="fa fa-edit"></i></a></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Prices Section -->
<section class="no-padding-bottom">
    <div class="container-fluid">
        <div class="row">
            <!-- PriceCategories column -->
            <div class="col-lg-6 col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>{{__('ticketshop.price-categories')}}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6" style="padding-bottom: 10px">
                                <button class="btn btn-primary" data-toggle="modal" data-target="#createPriceCategoryModal"><i class="fa fa-plus"></i> {{__('ticketshop.new_category')}}</button>
                            </div>
                            <div class="col-lg-6">
                                <p></p>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table id="projects" style="width: 100%;" class="table datatable">
                                <thead>
                                    <tr>
                                        <th>{{__('ticketshop.id')}}</th>
                                        <th>{{__('ticketshop.name')}}</th>
                                        <th>{{__('ticketshop.description')}}</th>
                                        <th>{{__('ticketshop.price')}}</th>
                                        <th>{{__('ticketshop.actions')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pricecategories as $category)
                                    <tr>
                                        <td>{{ $category->id }}</td>
                                        <td>{{ $category->name }}</td>
                                        <td>{{ $category->description }}</td>
                                        <td>{{ $category->price }}</td>
                                        <td><a class="btn btn-primary" href="{{ route('admin.dependencies.prices.category.get', $category) }}"><i class="fa fa-edit"></i></a></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div> <!-- End projects card -->
            </div> <!-- End PriceCategories col-div -->

            <!-- PriceList column -->
            <div class="col-lg-6 col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>{{__('ticketshop.price-lists')}}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6" style="padding-bottom: 10px">
                                <button class="btn btn-primary" data-toggle="modal" data-target="#createPriceListModal"><i class="fa fa-plus"></i> {{__('ticketshop.new_list')}}</button>
                            </div>
                            <div class="col-lg-6">
                                <p></p>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table id="archive" style="width: 100%;" class="table datatable">
                                <thead>
                                    <tr>
                                        <th>{{__('ticketshop.id')}}</th>
                                        <th>{{__('ticketshop.name')}}</th>
                                        <th>{{__('ticketshop.categories')}}</th>
                                        <th>{{__('ticketshop.actions')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pricelists as $list)
                                    <tr>
                                        <td>{{ $list->id }}</td>
                                        <td>{{ $list->name }}</td>
                                        <td>@foreach($list->categories as $category) <div class="badge badge-info">{{ $category->name }} ({{ $category->price }} <i class="fa fa-eur"></i> )</div> @endforeach</td>
                                        <td><a class="btn btn-primary" href="{{ route('admin.dependencies.prices.list.get', $list) }}"><i class="fa fa-edit"></i></a></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div> <!-- End archive card -->
            </div> <!-- End PriceList col-div -->
        </div> <!-- End row-div -->
    </div>
</section>

<!-- PriceCategoryModal -->
<div class="modal fade" id="createPriceCategoryModal" tabindex="-1" role="dialog" aria-labelledby="createPriceCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('admin.dependencies.prices.category.create') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="createPriceCategoryModalLabel">{{__('ticketshop.new_price_category')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label class="col-sm-3 form-control-label">{{__('ticketshop.name')}}</label>
                        <div class="col-sm-9">
                            <input type="text" name="name" class="form-control" placeholder="Enter new category name" required="required"/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 form-control-label">{{__('ticketshop.description')}}</label>
                        <div class="col-sm-9">
                            <input type="text" name="description" class="form-control" placeholder="Enter category description" required="required"/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 form-control-label">{{__('ticketshop.price')}}</label>
                        <div class="col-sm-9">
                            <input type="number" name="price" class="form-control" step="0.01" pattern="/[\d]{1-7}.[\d]{2}/" value="0.00" required="required"/>
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

<!-- PriceListModal -->
<div class="modal fade" id="createPriceListModal" tabindex="-1" role="dialog" aria-labelledby="createPriceListModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('admin.dependencies.prices.list.create') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="createPriceListModalLabel">{{__('ticketshop.new_price_list')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label class="col-sm-3 form-control-label">{{__('ticketshop.name')}}</label>
                        <div class="col-sm-9">
                            <input type="text" name="name" class="form-control" placeholder="Enter new list name" required="required"/>
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

<!-- Locations Section -->
<section class="no-padding-bottom">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h4>{{__('ticketshop.locations')}}</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6" style="padding-bottom: 10px">
                        <button class="btn btn-primary" data-toggle="modal" data-target="#createLocationModal"><i class="fa fa-plus"></i> {{__('ticketshop.new_location')}}</button>
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
                                <th>{{__('ticketshop.name')}}</th>
                                <th>{{__('ticketshop.address')}}</th>
                                <th>{{__('ticketshop.actions')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($locations as $location)
                            <tr>
                                <td>{{ $location->id }}</td>
                                <td>{{ $location->name }}</td>
                                <td>{{ $location->address }}</td>
                                <td><a class="btn btn-primary" href="{{ route('admin.dependencies.location.get', $location) }}"><i class="fa fa-edit"></i></a></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- LocationModal -->
<div class="modal fade" id="createLocationModal" tabindex="-1" role="dialog" aria-labelledby="createLocationModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('admin.dependencies.location.create') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="createLocationModalLabel">{{__('ticketshop.new_location')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label class="col-sm-3 form-control-label">{{__('ticketshop.name')}}</label>
                        <div class="col-sm-9">
                            <input type="text" name="name" class="form-control" placeholder="Enter new location name" required="required"/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 form-control-label">{{__('ticketshop.address')}}</label>
                        <div class="col-sm-9">
                            <input type="text" name="address" class="form-control" placeholder="Enter new location address" required="required"/>
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