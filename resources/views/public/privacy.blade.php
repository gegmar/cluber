@extends('layouts.common')

@section('title', 'Ticketshop')

@section('page-title', __('ticketshop.privacy_statement'))

@section('content')
<!---  Breadcrumb -->
<div class="breadcrumb-holder container-fluid">
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('ts.events') }}">{{__('ticketshop.back_to_events')}}</a></li>
    </ul>
</div>
<section>
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h4>{{__('ticketshop.privacy_statement')}}</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                        <h1>Erklärung zur Informationspflicht (Datenschutzerklärung)</h1>

                        <p>Der Schutz Ihrer persönlichen Daten ist uns ein besonderes Anliegen. Wir verarbeiten Ihre Daten daher ausschließlich auf Grundlage der gesetzlichen Bestimmungen (DSGVO, TKG 2003). In diesen Datenschutzinformationen informieren wir Sie über die wichtigsten Aspekte der Datenverarbeitung im Rahmen unserer Website.</p>

                        <h2>Kontakt mit uns</h2>
                        <p>Wenn Sie per Formular auf der Website oder per E-Mail Kontakt mit uns aufnehmen, werden Ihre angegebenen Daten zwecks Bearbeitung der Anfrage und für den Fall von Anschlussfragen sechs Monate bei uns gespeichert. Diese Daten geben wir nicht ohne Ihre Einwilligung weiter.</p>

                        <h2>Datenspeicherung</h2>

                        <p>Wir weisen darauf hin, dass zum Zweck des einfacheren Einkaufsvorganges und zur späteren Vertragsabwicklung vom Webshop-Betreiber die IP-Daten des Anschlussinhabers gespeichert werden, ebenso wie Name und E-Mailadresse des Käufers.</p>

                        <p>Darüber hinaus werden zum Zweck der Vertragsabwicklung folgende Daten auch bei uns gespeichert:</p>
                        <ul>
                            <li>Einkäufe und deren Bezahlstatus</li>
                            <li>Rechte und Rollen im System</li>
                        </ul>

                        <p>Die von Ihnen bereit gestellten Daten sind zur Vertragserfüllung bzw zur Durchführung vorvertraglicher Maßnahmen erforderlich. Ohne diese Daten können wir den Vertrag mit Ihnen nicht abschließen. Eine Datenübermittlung an Dritte erfolgt nicht, mit Ausnahme unseres Steuerberaters zur Erfüllung unserer steuerrechtlichen Verpflichtungen.</p>

                        <p>Die Bezahlvorgänge werden durch unsere Zahlungsanbieter PayPal und Klarna (Sofortüberweisung) durchgeführt. Beide Anbieter verwalten gesondert ihre Zahlungen, sodass wir keine Ihrer Zahlungsdaten speichern müssen. Beide Anbieter übermitteln uns nur, ob eine Zahlung erfolgreich durchgeführt wurde oder nicht.</p>

                        <p>Nach Abbruch des Einkaufsvorganges werden die bei uns gespeicherten Daten gelöscht. Im Falle eines Vertragsabschlusses werden sämtliche Daten aus dem Vertragsverhältnis bis zum Ablauf der steuerrechtlichen Aufbewahrungsfrist (7 Jahre) gespeichert.</p>

                        <p>Die Daten Name, gekaufte Waren und Kaufdatum werden darüber hinaus bis zum Ablauf der jeweiligen Veranstaltungsjahre gespeichert. Die Datenverarbeitung erfolgt auf Basis der gesetzlichen Bestimmungen des § 96 Abs 3 TKG sowie des Art 6 Abs 1 lit a (Einwilligung) und/oder lit b (notwendig zur Vertragserfüllung) der DSGVO.</p>

                        <h2>Cookies</h2>

                        <p>Unsere Website verwendet so genannte Cookies. Dabei handelt es sich um kleine Textdateien, die mit Hilfe des Browsers auf Ihrem Endgerät abgelegt werden. Sie richten keinen Schaden an.</p>

                        <p>Wir nutzen Cookies dazu, um unsere Benutzer zu authentifizieren. Einige Cookies bleiben auf Ihrem Endgerät gespeichert, bis Sie diese löschen. Sie ermöglichen es uns, Ihren Browser beim nächsten Besuch wiederzuerkennen, sodass unsere Benutzer eingeloggt bleiben können.</p>

                        <p>Wenn Sie dies nicht wünschen, so können Sie Ihren Browser so einrichten, dass er Sie über das Setzen von Cookies informiert und Sie dies nur im Einzelfall erlauben.</p>

                        <p>Bei der Deaktivierung von Cookies funktioniert unserer Website nicht.</p>

                        <h2>Newsletter</h2>

                        <p>Sie haben die Möglichkeit, über unsere Website unseren Newsletter zu abonnieren. Hierfür benötigen wir Ihre E-Mail-Adresse und ihre Erklärung, dass Sie mit dem Bezug des Newsletters einverstanden sind.</p>

                        <p>Das Abo des Newsletters können Sie jederzeit stornieren. Senden Sie Ihre Stornierung bitte an folgende E-Mail-Adresse: {{ config('app.webmaster')}}. Wir löschen anschließend umgehend Ihre Daten im Zusammenhang mit dem Newsletter-Versand. Durch diesen Widerruf wird die Rechtmäßigkeit der aufgrund der Zustimmung bis zum Widerruf erfolgten Verarbeitung nicht berührt.</p>

                        <h2>Ihre Rechte</h2>

                        <p>Ihnen stehen bezüglich Ihrer bei uns gespeicherten Daten grundsätzlich die Rechte auf Auskunft, Berichtigung, Löschung, Einschränkung, Datenübertragbarkeit, Widerruf und Widerspruch zu. Wenn Sie glauben, dass die Verarbeitung Ihrer Daten gegen das Datenschutzrecht verstößt oder Ihre datenschutzrechtlichen Ansprüche sonst in einer Weise verletzt worden sind, können Sie sich bei der uns unter {{ config('app.webmaster') }} oder der Datenschutzbehörde beschweren.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection