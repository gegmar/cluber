<!-- sell Purchase Modal -->
{{--
    Requires to pass the $purchase variable via the component!
    @component('components.modals.sell-purchase', ['purchase' => $purchase])
    @endcomponent
--}}
<div class="modal fade" id="sellPurchaseModal" tabindex="-1" role="dialog" aria-labelledby="sellPurchaseModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('retail.sold.paid', ['purchase' => $purchase->random_id]) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="sellPurchaseModalLabel">{{__('ticketshop.sell_tickets')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>{{__('ticketshop.sell_purchase_warning')}}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('ticketshop.cancel')}}</button>
                    <button type="submit" class="btn btn-primary">{{__('ticketshop.sell')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>