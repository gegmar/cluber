<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
 */

    'accepted' => ':attribute muss akzeptiert werden.',
    'active_url' => ':attribute ist keine valide URL.',
    'after' => ':attribute muss eine Zeit nach :date sein.',
    'after_or_equal' => ':attribute muss eine Zeit nach oder genau :date sein.',
    'alpha' => ':attribute darf nur Buchstaben enthalten.',
    'alpha_dash' => ':attribute darf nur Buchstaben, Ziffern, Binde- und Unterstriche enthalten.',
    'alpha_num' => ':attribute darf nur Buchstaben und Ziffern enthalten.',
    'array' => ':attribute muss ein Array sein.',
    'before' => ':attribute muss eine Zeit vor :date sein.',
    'before_or_equal' => ':attribute muss eine Zeit vor oder genau :date sein.',
    'between' => [
        'numeric' => ':attribute muss zwischen :min und :max sein.',
        'file' => ':attribute muss zwischen :min und :max KBytes groß sein.',
        'string' => ':attribute muss zwischen :min und :max Zeichen lang sein.',
        'array' => ':attribute muss zwischen :min und :max Elemente enthalten.',
    ],
    'boolean' => ':attribute muss wahr oder falsch sein.',
    'confirmed' => ':attribute stimmt nicht mit der Bestätigung überein.',
    'date' => ':attribute ist kein valides Datum.',
    'date_format' => ':attribute entspricht nicht dem Format :format.',
    'different' => ':attribute und :other müssen sich unterscheiden.',
    'digits' => ':attribute muss aus :digits Ziffern bestehen.',
    'digits_between' => ':attribute muss zwischen :min und :max Zeichen bestehen.',
    'dimensions' => ':attribute hat eine ungültige Bildgröße.',
    'distinct' => ':attribute Feld hat einen oder mehrere doppelte Werte.',
    'email' => ':attribute muss eine valide E-Mailadresse sein.',
    'ends_with' => 'The :attribute must end with one of the following: :values',
    'exists' => 'Ausgewähltes :attribute ist nicht valide.',
    'file' => ':attribute muss eine Datei sein.',
    'filled' => ':attribute muss einen Wert haben.',
    'gt' => [
        'numeric' => ':attribute muss größer als :value sein.',
        'file' => ':attribute muss größer als :value KBytes sein.',
        'string' => ':attribute muss mehr als :value Zeichen haben.',
        'array' => ':attribute muss mehr als :value Elemente haben.',
    ],
    'gte' => [
        'numeric' => ':attribute muss größer oder gleich wie :value sein.',
        'file' => ':attribute muss größer oder gleich :value KBytes sein.',
        'string' => ':attribute muss :value oder mehr Zeichen haben.',
        'array' => ':attribute muss :value Elemente oder mehr haben.',
    ],
    'image' => ':attribute muss ein Bild sein.',
    'in' => 'Ausgewähltes :attribute ist ungültig.',
    'in_array' => ':attribute existiert in :other nicht.',
    'integer' => ':attribute muss eine Zahl sein.',
    'ip' => ':attribute muss eine gültige IP-Adresse sein.',
    'ipv4' => 'attribute muss eine gültige IPv4-Adresse sein.',
    'ipv6' => 'attribute muss eine gültige IPv6-Adresse sein.',
    'json' => ':attribute muss ein valider JSON-String sein.',
    'lt' => [
        'numeric' => ':attribute muss kleiner als :value sein.',
        'file' => ':attribute muss kleiner als :value KBytes sein.',
        'string' => ':attribute muss weniger als :value Zeichen haben.',
        'array' => ':attribute muss weniger als :value Elemente enthalten.',
    ],
    'lte' => [
        'numeric' => ':attribute muss weniger oder gleich :value sein.',
        'file' => ':attribute muss kleiner oder gleich :value KBytes groß sein.',
        'string' => ':attribute muss weniger oder gleich viele Zeichen als :value haben.',
        'array' => ':attribute darf nicht mehr als :value Elemente enthalten.',
    ],
    'max' => [
        'numeric' => ':attribute darf nicht größer als :max sein.',
        'file' => ':attribute darf nicht größer als :max KBytes sein.',
        'string' => ':attribute darf micht mehr als :max Zeichen lang sein.',
        'array' => ':attribute darf nicht mehr als :max Elemente enthalten.',
    ],
    'mimes' => ':attribute muss eine Datei eines dieser Typen sein: :values.',
    'mimetypes' => ':attribute muss eine Datei eines dieser Typen sein: :values.',
    'min' => [
        'numeric' => ':attribute muss mindestens :min groß sein.',
        'file' => ':attribute muss mindestens :min KBytes groß sein.',
        'string' => ':attribute muss mindestens :min Zeichen lang sein.',
        'array' => ':attribute muss mindestens :min Elemente enthalten.',
    ],
    'not_in' => 'Das ausgewählte :attribute ist ungültig.',
    'not_regex' => 'Das Format von :attribute ist ungültig.',
    'numeric' => ':attribute muss eine Nummer sein.',
    'present' => ':attribute muss vorhanden sein.',
    'regex' => 'Das Format von :attribute ist ungültig.',
    'required' => ':attribute wird vorausgesetzt.',
    'required_if' => ':attribute wird vorausgesetzt wenn :other den Wert :value hat.',
    'required_unless' => ':attribute wird vorausgesetzt solange sich :other nicht in :values befindet.',
    'required_with' => ':attribute Feld wird vorausgesetzt, wenn :values vorhanden ist.',
    'required_with_all' => ':attribute Feld wird vorausgesetzt, wenn :values vorhanden ist.',
    'required_without' => ':attribute Feld wird vorausgesetzt, wenn keines von :values vorhanden ist.',
    'required_without_all' => ':attribute Feld wird vorausgesetzt, wenn keines von :values vorhanden ist.',
    'same' => ':attribute und :other müssen gleich sein.',
    'size' => [
        'numeric' => ':attribute muss :size groß sein.',
        'file' => ':attribute muss :size KBytes groß sein.',
        'string' => ':attribute muss :size Zeichen lang sein.',
        'array' => ':attribute muss :size Elemente enthalten.',
    ],
    'string' => ':attribute muss ein string sein.',
    'timezone' => ':attribute muss eine valide Zone sein.',
    'unique' => ':attribute wird bereits verwendet.',
    'uploaded' => ':attribute konnte nicht hochgeladen werden.',
    'url' => ':attribute Format ist ungültig.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
     */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
     */

    'attributes' => [],

];
