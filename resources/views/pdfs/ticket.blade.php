<page format="100x200" orientation="L" backcolor="#ffffff" style="font: arial;">
    <div style="rotate: 90; position: absolute; width: 100mm; height: 4mm; left: 195mm; top: 0; font-style: italic; font-weight: normal; text-align: center; font-size: 2.5mm;">
        Ticket beim Veranstaltungseingang als Eintrittskarte vorweisen -
        erzeugt von <a href="http://html2pdf.fr/" style="color: #222222; text-decoration: none;">html2pdf</a>
    </div>
    <table style="width: 98%;border: none;" cellspacing="1mm" cellpadding="0">
        <tr>
            <td colspan="2" style="width: 100%">
                <div class="zone" style="height: 20mm;position: relative;font-size: 5mm;">
                    <div style="position: absolute; right: 3mm; top: 3mm; text-align: right; font-size: 4mm; ">
                        <b></b>
                        <br>
                        @if($ticket->purchase->customer_id != null)
                        Ausgestellt für : <b>@if ( $ticket->purchase->customer_name != null ) {{ $ticket->purchase->customer_name }} @else {{ $ticket->purchase->customer->name }} @endif</b><br>@endif
                        Ausgestellt am : <b>@datetime($ticket->purchase->state_updated) @time($ticket->purchase->state_updated)</b>
                        <br>
                    </div>
                    <div style="position: absolute; right: 3mm; bottom: 3mm; text-align: right; font-size: 4mm; ">
                        {{--
                        Reihe : <b>ROW</b><br>
                        Platz : <b>SEAT</b><br>
                        --}}
                        Eindeutige ID: <b>{{ $ticket->id }}</b>
                        <br>
                        Preis: <b>{{ $ticket->priceCategory->price }} € ({{ $ticket->priceCategory->name }})</b>
                        <br><br>
                        Ort: <b>{{ $ticket->event->location->name }}</b>
                        <br>
                        Adresse: <b>{{ $ticket->event->location->address }}</b>
                        <br>
                    </div>
                    <h1>{{ $ticket->event->project->name }}</h1>
                    <h2>{{ $ticket->event->second_name }}</h2>
                    <br>
                    &nbsp;&nbsp;&nbsp;&nbsp;<b>Gültig am @datetime($ticket->event->start_date) @time($ticket->event->start_date)</b>
                    <br>
                    {{--<img src="{{ asset('img/logos/theater-logo.png') }}" alt="logo" style="margin-top: 3mm; margin-left: 20mm; height: 20mm;">--}}
                </div>
            </td>
        </tr>
        <tr>
            <td style="width: 25%;">
                <div class="zone" style="height: 40mm;vertical-align: middle;text-align: center;">
                    <qrcode value="{{ route('ticket.show', ['ticket' => $ticket]) }}" ec="Q" style="width: 37mm; border: none;" ></qrcode>
                </div>
            </td>
            <td style="width: 75%">
                <div class="zone" style="height: 40mm;vertical-align: middle; text-align: justify">
                    <b>Mit dem Ticketkauf verbundene Bedingungen</b><br>
                    Dieses Ticket gilt als Platzkarte für eine Person. Bitte bringen Sie dieses Ticket zur Veranstaltung mit.
                    Erst durch das Vorweisen des Tickets werden Sie eingelassen. Sie können das Ticket sowohl als Ausdruck auf
                    Papier als auch auf einem mobilen Endgerät vorweisen. Es muss auf jeden Fall der QR-Code einlesbar sein.<br>
                    Die Rückgabe dieses Tickets gegen seinen Kaufwert kann aus technischen Gründen nur bei der jeweiligen Veranstaltungskassa
                    vor Veranstaltungsbeginn erfolgen.<br>
                    <br>
                    <i>Jedes Ticket ist durch dessen QR-Code in der linken unteren Ecke geschützt. Durch Einscannen werden Sie
                    auf unseren Online-Ticketshop geführt. Dort sehen Sie neben den gleichen Details wie auf diesem Ticket,
                    ob dieses Ticket echt und noch gültig ist.<br>
                    Bei technischen Fragen oder bei Betrugsversuchen kontaktieren Sie uns bitte unter {{ config('app.owner_webmaster') }}!</i>
                </div>
            </td>
        </tr>
    </table>
</page>