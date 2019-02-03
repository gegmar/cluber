@extends('layouts.common')

@section('title', 'Ticketshop')

@section('page-title', __('ticketshop.terms'))

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
                <h4>{{__('ticketshop.terms')}}</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                        <p>Die AGB regeln die rechtlichen Beziehungen zwischen uns und unseren Besuchern. Ihr Geltungsbereich erstreckt sich auf Vorstellungen in allen unseren Spielstätten sowie auf alle Vorstellungen, für die wir Eintrittskarten (Karten) verkaufen.</p>
                        
                        <h2>Theaterbesuchsvertrag</h2>
                        <p>Zwischen uns und dem Eintrittskartenkäufer kommt ein Theaterbesuchsvertrag zustande, sobald die Eintrittskarte an den Käufer übergeben, versendet oder für diesen an den Kassen hinterlegt wird. Die Reservierung oder Onlinebuchung sowie eine Reservierungs- oder Buchungsbestätigung führen noch nicht zum Vertragsabschluss. Eintrittskarten sind Inhaberpapiere, welche den Inhaber zur Inanspruchnahme der auf der Eintrittskarte bezeichneten Leistung berechtigen. Durch Übertragung der Eintrittskarte auf eine dritte Person (Inhaber) geht auch der Theaterbesuchsvertrag (inkl. AGB) auf diese Person über.</p>

                        <h2>Eintrittskarten</h2>
                        <p>Informationen zu Ermäßigungen erhalten Sie an den Kassen. Ermäßigte Karten können nur erworben werden, wenn die Ermäßigungsvoraussetzungen durch einen gültigen Ausweis nachgewiesen werden. Ein Rechtsanspruch auf ermäßigte Karten, auf bestimmte Karten oder Platzgruppen besteht nicht. Pro Person wird nur eine ermäßigte Karte abgegeben. Bei unberechtigter Inanspruchnahme einer Ermäßigung kann die Differenz auf den vollen Kartenpreis eingehoben oder der Besucher der Vorstellung verwiesen werden. Der Kaufpreis wird im zweiten Falle nicht erstattet.</p>

                        <h2>Eintrittskartenerwerb</h2>
                        <ol>
                            <li>Karten erhalten Sie zu den jeweiligen Öffnungszeiten an den Tageskassen, an den Abendkassen für die jeweilige Vorstellung sowie in unserem Webshop unter {{ route('start')}}.</li>
                            <li>Die Abendkassen in allen Spielstätten sind jeweils 30 Minuten vor Vorstellungsbeginn geöffnet.</li>
                            <li>Die Bezahlung der Karten vor Ort kann in bar erfolgen.</li>
                            <li>Wird die Zusendung bereits bezahlter Karten nicht gewünscht werden die Karten bis Veranstaltungsbeginn an der Abendkasse bereitgehalten.</li>
                            <li>Eine Bestellung von Karten, die bis 48 Stunden vor Veranstaltungsbeginn nicht vollständig bezahlt wurde (d.h. Gutschrift auf dem Konto des Salzburger Landestheater oder Bestätigung des Betrages durch das Kreditkartenunternehmen), verfällt.</li>
                            <li>Ab 24 Stunden vor Beginn der Veranstaltung können Karten an den Kassen nur noch bar erworben werden.</li>
                        </ol>

                        <h2>Besonderheiten beim Online-Kartenkauf</h2>
                        <p>Bei der Online-Bestellung in unserem Webshop ist die Bezahlung der Karten mit Kreditkarte, als Sofortüberweisung per Online-Banking oder über PayPal in der Regel bis 24 Stunden vor Vorstellungsbeginn möglich. Die Abwicklung der online Zahlung erfolgt über die jeweiligen Zahlungsanbieter mittels einer gesicherten Datenübertragung (https). Wir übernehmen keine Haftung für Schäden, die durch kriminelle Machenschaften oder Manipulationen von Dritten entstehen. Print@home-/E-Eintrittskarten werden am Eingang der Veranstaltung geprüft. Ist der QR-Code auf den Karten vom elektronischen Zutrittssystem nicht lesbar, besteht kein Anspruch auf Einlass zur Veranstaltung. Wird ein Besucher aus diesem Grund abgewiesen, besteht kein Anspruch auf Rückerstattung des bezahlten Kartenpreises. Der erste Inhaber einer Print@home-/E-Eintrittskarte erhält Einlass zur Veranstaltung, danach wird die Karte für weitere Zutritte gesperrt. Eintrittskarten sind vor Schmutz und Beschädigung zu schützen.</p>

                        <h2>Rücktrittsrecht im Fernabsatz (betreff. Online-Bestellungen in unserem Webshop)</h2>
                        <p>Das Rücktrittsrecht im Fernabsatz gemäß § 11 Fern- und Auswärtsgeschäftegesetz („FAGG“) gilt nicht für den Erwerb von Eintrittskarten in unserem Webshop, da es sich bei diesen Leistungen um Freizeitdienstleistungen im Sinne des § 18 Abs 1 Z 10 FAGG handelt.</p>

                        <h2>Rücknahme von bzw. Ersatzleistung für Eintrittskarten</h2>
                        <p>Gelöste Karten werden nicht umgetauscht, der Kaufpreis nicht rückerstattet. Ein Ersatz für nicht oder nur teilweise in Anspruch genommene Karten oder verlorene Karten kann nicht geleistet werden. Bis 3 Tage vor der Vorstellung kann je nach Verfügbarkeit eine Umbuchung auf einen gleichwertigen Platz in einer Vorstellung innerhalb der laufenden Spielzeit erfolgen. Umbuchungen können nur an der Tageskasse gegen Vorlage der Originalkarten vorgenommen werden. Ein Rechtsanspruch des Käufers auf eine Umbuchung besteht nicht. Für jede durchgeführte Umbuchung wird eine Umbuchungsgebühr in Höhe von 3 € pro Karte berechnet. Karten die mit der Versandart „print@home“ gebucht werden sind ausnahmslos von einer Umbuchung ausgeschlossen.</p>

                        <h2>Ausfall oder Änderung von Vorstellungen</h2>
                        <p> Wir behalten uns grundsätzlich vor, Vorstellungsdaten bzw. Vorstellungen zu ändern oder abzusagen, sofern beispielsweise Darsteller aus Krankheitsgründen nicht auftreten können, dies betriebstechnische Gründe nötig machen oder andere zwingende Gründe vorliegen. Wird anstelle einer Vorstellung, die auf der Eintrittskarte aufgedruckt ist, eine andere gespielt, so kann mit dieser Eintrittskarte die geänderte Vorstellung besucht werden. Bereits gekaufte Eintrittskarten werden im Falle einer Vorstellungsänderung, jedoch auf Wunsch im Kartenservice auch gegen eine Eintrittskarte für die ursprünglich vorgesehene Vorstellung zu anderem Termin umgetauscht oder aber gänzlich zurückgenommen. Es erfolgt eine Rückzahlung des bezahlten Betrages. Ein Rechtsanspruch auf Information über einen Ausfall oder eine Änderung einer Vorstellung besteht nicht. Schadenersatzforderungen wegen nicht erfolgter Information gegen uns sind ausgeschlossen. Die vorgenannte Haftungsbeschränkung gilt nicht in Fällen grober Fahrlässigkeit oder bei Vorsatz. Kurzfristige zeitliche Verschiebungen des Vorstellungsbeginns berechtigen nicht zur Rückgabe der erworbenen Karten. Muss eine Vorstellung, aus welchen Gründen auch immer, abgebrochen werden, und ist zum Zeitpunkt des Abbruchs weniger als die Hälfte der Aufführung (reine Spielzeit) gespielt, so wird von uns eine Ersatzvorstellung oder ein Ersatztermin angeboten. Sollte dies nicht möglich sein, wird der Eintrittspreis rückerstattet. Die allgemeinen gesetzlichen Gewährleistungsbestimmungen werden dadurch nicht ausgeschlossen.</p>

                        <h2>Nacheinlass</h2>
                        <p>Nach Beginn einer Veranstaltung besteht kein Anspruch auf Nacheinlass und es erlischt der ursprüngliche Sitzplatzanspruch. Der Publikumsdienst kann jedoch in geeigneten Momenten nach Möglichkeit und eigenem Ermessen einen Nacheinlass ermöglichen. In diesem Fall weist der Publikumsdienst dem Theaterbesucher nach Verfügbarkeit einen neuen Sitzplatz zu, der möglichst ohne Störung der übrigen Besucher einzunehmen ist. Den Anweisungen des Publikumsdienstes ist unbedingt Folge zu leisten.</p>

                        <h2>Keine Haftung für Gesundheitsschäden</h2>
                        <p>Wir übernehmen keine Haftung für Gesundheitsschäden, die infolge von Lautstärke und/oder Lichteinwirkung bei Veranstaltungen entstehen können. Jedwede Schadenersatzansprüche sind ausgeschlossen, soweit wir, unsere Vertreter oder Erfüllungsgehilfe nicht grob fahrlässig oder vorsätzlich gehandelt haben.</p>

                        <h2>Bild- und Tonaufzeichnungen</h2>
                        <p>Der Karteninhaber willigt ein, dass die im Rahmen der Veranstaltung von ihm erstellten Bild-, Video- und Tonaufzeichnungen in jedweder Form und ohne zeitliche Begrenzung entschädigungslos verwertet werden dürfen.</p>

                        <h2>Hausrecht / Verbot von Bild-, Video-- und Tonaufnahmen</h2>
                        <p>Dem Publikumsdienst ist auf Verlangen die gültige Eintrittskarte vorzuweisen. Jede gültige Eintrittskarte berechtigt zum Besuch der darauf angegebenen Vorstellung. Es darf nur der auf der Eintrittskarte angegebene Platz eingenommen werden. Ermäßigte Karten sind nur in Verbindung mit dem die Ermäßigung begründenden Ausweis gültig.</p>

                        <p>Der Zutritt zum Veranstaltungsort kann Personen verweigert werden, wenn befürchtet werden muss, dass durch sie die Vorstellung gestört oder andere Besucher belästigt werden. Der Zutritt kann ferner verweigert werden, wenn Personen bereits in früheren Vorstellungen die AGB, die Hausordnung oder andere für uns gültige Regularien oder Gesetze nicht eingehalten haben. Besucher können aus der laufenden Vorstellung verwiesen werden, wenn sie diese stören, andere Besucher oder die Künstler belästigen oder einen Platz eingenommen haben, für den sie keine gültige Karte haben. In diesen Fällen erfolgt keine Rückerstattung des Kartenpreises. Der Gebrauch von Handys im Zuschauerraum ist nicht gestattet. Das Herstellen von Bild-, Video und Tonaufnahmen aller Art durch Besucher im Zuschauerraum ist untersagt. Die Mitnahme von Speisen oder Getränken in den Zuschauerraum und der dortige Verzehr sind nicht gestattet. Das Rauchen ist in allen unseren Räumen untersagt.</p>

                        <p>Es gilt die jeweils aktuelle Fassung der Hausordnung des Veranstaltungsortes, welche an der Tageskasse und im Abobüro zur Einsicht aufliegt.</p>


                        <h2>Urheberrechte – Inhalte der Drucksorten und der Internetseite</h2>
                        <p>In unseren Publikationen ist jeweils ein Impressum vorhanden. Die Nutzung der in den Publikationen enthaltenen Texte und Abbildungen – auch nur in Auszügen – ist nur nach unserer ausdrücklichen Genehmigung gestattet. Für etwaige Druckfehler wird keine Haftung übernommen. Wir übernimmen keine Haftung für etwaige Fehler oder Schadhaftigkeit unserer Homepage. Die Benutzung der Homepage sowie angegebener Links erfolgt auf eigenes Risiko. Eine Gewährleistung oder Haftung  für Inhalte von verlinkten Drittseiten wird ausgeschlossen.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection