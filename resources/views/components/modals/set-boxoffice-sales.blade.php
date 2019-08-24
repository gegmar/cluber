<!-- set Box Office Sales Modal -->
{{--
    Requires to pass the $event variable via the component!
    @component('components.modals.set-boxoffice-sales', ['event' => $event])
    @endcomponent
--}}
<div class="modal fade" id="boxofficeModal" tabindex="-1" role="dialog" aria-labelledby="boxofficeModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('boxoffice.set-sales', [$event]) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="boxofficeModalLabel">{{__('ticketshop.set_box_office_sales')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @php
                        // Only perform the call to ticketList() once
                        $boxofficePurchase = $event->boxoffice;
                        if($boxofficePurchase) {
                            $boxofficeTickets = $boxofficePurchase->ticketList();
                        }
                    @endphp
                    @foreach( $event->priceList->categories as $category)
                    <div class="form-group row">
                        <label class="col-sm-3 form-control-label">{{ $category->name }} ({{ $category->price }} <i class="fa fa-eur"></i>) @if($category->description)<i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="{{$category->description}}"></i>@endif</label>
                        <div class="col-sm-9">
                        <input type="text" name="tickets[{{ $category->id }}]" class="form-control" @if($boxofficePurchase && $boxofficeTickets->has($category->name)) value="{{ $boxofficeTickets[$category->name]['count'] }}" @else value="0" @endif>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('ticketshop.cancel')}}</button>
                    <button type="submit" class="btn btn-primary">{{__('ticketshop.save')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>