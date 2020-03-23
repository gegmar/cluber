{{-- Place the headers by getting the keys of the first event --}}
{{ implode(';', array_keys($data[0]) ) }}
@foreach ($data as $event)
{{ implode(';', array_values($event) ) }}
@endforeach