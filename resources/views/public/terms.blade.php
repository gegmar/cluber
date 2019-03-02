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
                        <h2>Allgemeine Geschäftsbedingungen Theater Kirchdorf</h2>
                        <h3>1. Geltung der AGBs</h3>
                        <ol>
                            <li>Der Vertrag zwischen dem Theater Kirchdorf und TheaterbesucherInnen über den Besuch einer Vorstellung wird mit der Aushändigung der Eintrittskarte an die TheaterbesucherInnen abgeschlossen. Mit der Erklärung, eine Eintrittskarte erwerben zu wollen, unterwirft sich der/die BesucherIn diesen Allgemeinen Geschäftsbedingungen (,,AGB"). Dies gilt auch für den Fall, dass der/die BesucherIn die Eintrittskarte telefonisch, per Internet oder per anderen Kommunikationstechniken bestellt.</li>
                            <li>Mit der Übertragung der Theaterkarte auf eine/n Dritte/n, wird das Vertragsverhältnis unter Anwendung dieser AGB auf den/die ErwerberIn übertragen. Der/die Veräußerer/in der Theaterkarte ist verpflichtet, den/die ErwerberIn auf die Geltung dieser AGB hinzuweisen.</li>
                            <li>Für Personen, die sich in den Theaterräumlichkeiten aufhalten, ohne dass diese AGB im Wege eines Vertragsabschlusses wirksam werden, gelten diese AGB als Hausordnung.</li>
                        </ol>
                        
                        <h3>2. Erwerb der Theaterkarte</h3>
                        <ol>
                            <li>Für den Erwerb der Eintrittskarte gelten die für die jeweilige Vorstellung ausgewiesenen Preise. Die Preise enthalten die gesetzlich vorgeschriebenen Steuern und Abgaben.</li>
                            <li>Der/die TheaterbesucherIn ist verpflichtet, sofort nach Übernahme der Eintrittskarte zu prüfen, ob er/sie die Karte für die gewünschte Vorstellung erhalten hat. Nachträgliche Reklamationen werden nicht berücksichtigt.</li>
                            <li>Der Theaterbetreiber behält sich das Recht vor, BesucherInnen, die andere BesucherInnen oder MitarbeiterInnen des Theaterbetreibers belästigen und/oder die sich Anordnungen des Personals widersetzen, den Erwerb von Eintrittskarten für bestimmte Zeit oder in schwerwiegenden Fällen auf Dauer zu versagen.</li>
                            <li>Bei Vorbestellung müssen die Eintrittskarten spätestens 30 Minuten vor der Vorführung abgeholt und bezahlt werden. Nicht fristgerecht abgeholte Eintrittskarten kann der Betreiber ohne Rücksichtnahme auf die Vorbestellung verkaufen.</li>
                            <li>Eine Rücknahme oder ein Umtausch bezahlter Eintrittskarten ist nicht möglich. Ein Ersatz für nicht oder (durch Zu-Spät-Kommen) nur teilweise in Anspruch genommene Eintrittskarten oder für wie immer abhanden gekommene Eintrittskarten wird nicht geleistet.</li>
                        </ol>

                        <h3>3. Zutritt zum Theatersaal</h3>
                        <ol>
                            <li>Die Berechtigung, einer bestimmten Theatervorführung beizuwohnen, wird mit der gültigen Karte ausgewiesen. Der Betreiber ist nicht verpflichtet, zu prüfen, ob der/die BesucherIn die Eintrittskarte rechtmäßig erworben hat.</li>
                            <li>Der Theatersaal darf ohne eine gültige Eintrittskarte nicht betreten werden. Der Betreiber behält sich das Recht vor, die Zutrittsberechtigung zu prüfen und bei fehlender Zutrittsberechtigung, den Zutritt zu dem Theatersaal zu verweigern bzw. den/die BesucherIn der Vorführung zu verweisen. Der/die BesucherIn hat daher die Eintrittskarte bis zum Ende der Vorführung aufzubewahren.</li>
                            <li>Die Mitnahme von Waffen, Fotoapparaten, Digitalkameras, Video-, DVD- und ähnlichen Bild- oder Ton-Aufnahmegeräten in den Theatersaal ist nicht gestattet. Besucher sind verpflichtet, derartige Gegenstände vor dem Betreten des Theatersaales an der Kassa abzugeben und nach dem Verlassen des Theatersaales abzuholen. Geräte, die binnen drei Tagen nach dem Tag der Vorstellung nicht abgeholt werden, werden dem Fundamt übergeben.</li>
                            <li>Die Mitnahme von Speisen und/oder Getränken in den Theatersaal ist nicht zulässig.</li>
                        </ol>

                        <h3>4. Verhalten im Theatersaal</h3>
                        <ol>
                            <li>BesucherInnen können nach einer Mahnung des Personals ohne Rückzahlung des Eintrittspreises der Vorführung verwiesen werden, wenn sie:
                                <ol>
                                    <li>sich weigern, ihren auf der Eintrittskarte zugewiesenen Platz einzunehmen;</li>
                                    <li>andere Besucher vor oder während der Vorführung akustisch, durch ihr Verhalten oder ihren Geruch stören oder belästigen;</li>
                                    <li>im Theatersaal rauchen;</li>
                                    <li>Essensreste auf den Boden werfen oder sonst den Theatersaal verunreinigen;</li>
                                    <li>Waffen oder sonstige gemäß Punkt 11. verbotene Gegenstände - in den Theatersaal mitnehmen, und zwar unabhängig davon, ob diese konkret benutzt werden oder nicht;</li>
                                    <li>ohne Genehmigung des Betreibers Speisen und/oder Getränke in den Theatersaal mitnehmen.</li>
                                </ol>
                            </li>
                            <li>Nach dem Ende der Vorführung ist der Theatersaal durch die bezeichneten Ausgänge zu verlassen. Der Aufenthalt im Theatersaal ist nach dem Ende der Vorführung unzulässig.</li>
                        </ol>

                        <h3>5. Verbot von Bild- und Tonaufnahmen</h3>
                        <ol>
                            <li>Theateraufführungen sind urheberrechtlich geschützte Werke. Das Vervielfältigen, Verbreiten oder das öffentliche Aufführen dieser Werke ohne ausdrückliche schriftliche Zustimmung des Rechteinhabers (Lizenzvereinbarung) ist gerichtlich strafbar. Bild- oder Tonbandaufnahmen während einer Vorführung sind daher (auch für private Zwecke) unter keinen Umständen zulässig.</li>
                            <li>Liegen Gründe vor, anzunehmen, dass ein/e TheaterbesucherIn unzulässige Bild- oder Tonaufnahmen während der Vorführung angefertigt hat oder anzufertigen versucht hat, kann ihn/sie das Personal in angemessener Weise anhalten (§ 86 Abs 2 StPO). Das Personal wird die Anhaltung unverzüglich dem nächsten Sicherheitsorgan bekannt geben.</li>
                            <li>Die Anhaltung kann unterbleiben, wenn der Besucher der Aufforderung des Personals, seine Identität nachzuweisen nachkommt und das Gerät, mit dem die Bild- oder Tonaufnahme erfolgt sein könnte, in die Verwahrung des Personals übergibt. Der Betreiber wird in diesem Fall unverzüglich entsprechende rechtliche Schritte zur Klärung des Sachverhalts einleiten. Werden die in Verwahrung genommenen Gegenstände nicht binnen acht Wochen gerichtlich beschlagnahmt, werden sie dem/der BesucherIn an der Theaterkassa zurückerstattet. Eine Versendung der in Verwahrung übernommenen Gegenstände kann nur auf Kosten und Risiko des/der Besuchers/in erfolgen.</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection