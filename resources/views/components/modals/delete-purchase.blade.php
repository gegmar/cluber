<!-- delete Purchase Modal -->
{{--
    Requires to pass the $purchase variable via the component!
    @component('components.modals.delete-purchase', ['purchase' => $purchase])
    @endcomponent
--}}
<div class="modal fade" id="deletePurchaseModal" tabindex="-1" role="dialog" aria-labelledby="deletePurchaseModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('retail.sold.delete', ['purchase' => $purchase->random_id]) }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-header">
                    <h5 class="modal-title" id="deletePurchaseModalLabel">{{__('ticketshop.delete_purchase')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>{{__('ticketshop.delete_purchase_warning')}}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('ticketshop.cancel')}}</button>
                    <button type="submit" class="btn btn-danger">{{__('ticketshop.delete')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>