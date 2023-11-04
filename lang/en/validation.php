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

    'accepted' => ':Attribute mesti diterima.',
    'accepted_if' => ':Attribute mesti diterima apabila :other adalah :value.',
    'active_url' => ':Attribute bukan URL yang sah.',
    'after' => ':Attribute mesti tarikh selepas :date.',
    'after_or_equal' => ':Attribute mesti tarikh selepas atau sama dengan :date.',
    'alpha' => ':Attribute hanya boleh mengandungi huruf.',
    'alpha_dash' => ':Attribute hanya boleh mengandungi huruf, nombor, tanda sengkang, dan garis bawah.',
    'alpha_num' => ':Attribute hanya boleh mengandungi huruf dan nombor.',
    'array' => ':Attribute mesti menjadi array.',
    'before' => ':Attribute mesti tarikh sebelum :date.',
    'before_or_equal' => ':Attribute mesti tarikh sebelum atau sama dengan :date.',
    'between' => [
        'numeric' => ':Attribute mesti antara :min dan :max.',
        'file' => ':Attribute mesti antara :min dan :max kilobait.',
        'string' => ':Attribute mesti antara :min dan :max karakter.',
        'array' => ':Attribute mesti mengandungi antara :min dan :max item.',
    ],
    'boolean' => ':Attribute mesti benar atau salah.',
    'confirmed' => 'Pengesahan :attribute tidak sepadan.',
    'current_password' => 'Kata laluan tidak betul.',
    'date' => ':Attribute bukan tarikh yang sah.',
    'date_equals' => ':Attribute mesti tarikh yang sama dengan :date.',
    'date_format' => ':Attribute tidak sepadan dengan format :format.',
    'declined' => ':Attribute mesti ditolak.',
    'declined_if' => ':Attribute mesti ditolak apabila :other adalah :value.',
    'different' => ':Attribute dan :other mesti berbeza.',
    'digits' => ':Attribute mesti :digits digit.',
    'digits_between' => ':Attribute mesti antara :min dan :max digit.',
    'dimensions' => ':Attribute mempunyai dimensi imej yang tidak sah.',
    'distinct' => ':Attribute medan mempunyai nilai berulang.',
    'email' => ':Attribute mesti alamat emel yang sah.',
    'ends_with' => ':Attribute mesti berakhir dengan salah satu dari: :values.',
    'enum' => ':Attribute yang dipilih tidak sah.',
    'exists' => ':Attribute yang dipilih tidak sah.',
    'file' => ':Attribute mesti fail.',
    'filled' => ':Attribute medan mesti mempunyai nilai.',
    'gt' => [
        'numeric' => ':Attribute mesti lebih besar daripada :value.',
        'file' => ':Attribute mesti lebih besar daripada :value kilobait.',
        'string' => ':Attribute mesti lebih besar daripada :value karakter.',
        'array' => ':Attribute mesti mengandungi lebih daripada :value item.',
    ],
    'gte' => [
        'numeric' => ':Attribute mesti lebih besar daripada atau sama dengan :value.',
        'file' => ':Attribute mesti lebih besar daripada atau sama dengan :value kilobait.',
        'string' => ':Attribute mesti lebih besar daripada atau sama dengan :value karakter.',
        'array' => ':Attribute mesti mengandungi :value item atau lebih.',
    ],
    'image' => ':Attribute mesti imej.',
    'in' => ':Attribute yang dipilih tidak sah.',
    'in_array' => 'Medan :attribute tidak wujud dalam :other.',
    'integer' => ':Attribute mesti integer.',
    'ip' => ':Attribute mesti alamat IP yang sah.',
    'ipv4' => ':Attribute mesti alamat IPv4 yang sah.',
    'ipv6' => ':Attribute mesti alamat IPv6 yang sah.',
    'json' => ':Attribute mesti rentetan JSON yang sah.',
    'lt' => [
        'numeric' => ':Attribute mesti kurang daripada :value.',
        'file' => ':Attribute mesti kurang daripada :value kilobait.',
        'string' => ':Attribute mesti kurang daripada :value karakter.',
        'array' => ':Attribute mesti mengandungi kurang daripada :value item.',
    ],
    'lte' => [
        'numeric' => ':Attribute mesti kurang daripada atau sama dengan :value.',
        'file' => ':Attribute mesti kurang daripada atau sama dengan :value kilobait.',
        'string' => ':Attribute mesti kurang daripada atau sama dengan :value karakter.',
        'array' => ':Attribute mesti tidak mempunyai lebih daripada :value item.',
    ],
    'mac_address' => ':Attribute mesti alamat MAC yang sah.',
    'max' => [
        'numeric' => ':Attribute tidak boleh lebih besar daripada :max.',
        'file' => ':Attribute tidak boleh lebih besar daripada :max kilobait.',
        'string' => ':Attribute tidak boleh lebih besar daripada :max karakter.',
        'array' => ':Attribute tidak boleh mengandungi lebih daripada :max item.',
    ],
    'mimes' => ':Attribute mesti fail jenis: :values.',
    'mimetypes' => ':Attribute mesti fail jenis: :values.',
    'min' => [
        'numeric' => ':Attribute mesti sekurang-kurangnya :min.',
        'file' => ':Attribute mesti sekurang-kurangnya :min kilobait.',
        'string' => ':Attribute mesti sekurang-kurangnya :min karakter.',
        'array' => ':Attribute mesti mengandungi sekurang-kurangnya :min item.',
    ],
    'multiple_of' => ':Attribute mesti nombor gandaan :value.',
    'not_in' => ':Attribute yang dipilih tidak sah.',
    'not_regex' => 'Format :attribute tidak sah.',
    'numeric' => ':Attribute mesti nombor.',
    'password' => 'Kata laluan tidak betul.',
    'present' => 'Medan :attribute mesti ada.',
    'prohibited' => 'Medan :attribute adalah dilarang.',
    'prohibited_if' => 'Medan :attribute adalah dilarang apabila :other adalah :value.',
    'prohibited_unless' => 'Medan :attribute adalah dilarang kecuali jika :other berada dalam :values.',
    'prohibits' => 'Medan :attribute melarang :other daripada wujud.',
    'regex' => 'Format :attribute tidak sah.',
    'required' => 'Medan :attribute diperlukan.',
    'required_array_keys' => 'Medan :attribute mesti mengandungi entri untuk: :values.',
    'required_if' => 'Medan :attribute diperlukan apabila :other adalah :value.',
    'required_unless' => 'Medan :attribute diperlukan kecuali jika :other berada dalam :values.',
    'required_with' => 'Medan :attribute diperlukan apabila :values hadir.',
    'required_with_all' => 'Medan :attribute diperlukan apabila :values hadir.',
    'required_without' => 'Medan :attribute diperlukan apabila :values tidak hadir.',
    'required_without_all' => 'Medan :attribute diperlukan apabila tiada :values yang hadir.',
    'same' => ':Attribute dan :other mesti sepadan.',
    'size' => [
        'numeric' => ':Attribute mesti :size.',
        'file' => ':Attribute mesti :size kilobait.',
        'string' => ':Attribute mesti :size karakter.',
        'array' => ':Attribute mesti mengandungi :size item.',
    ],
    'starts_with' => ':Attribute mesti bermula dengan salah satu daripada: :values.',
    'string' => ':Attribute mesti rentetan.',
    'timezone' => ':Attribute mesti zon masa yang sah.',
    'unique' => ':Attribute telah diambil.',
    'uploaded' => ':Attribute gagal dimuat naik.',
    'url' => ':Attribute format tidak sah.',
    'uuid' => ':Attribute mesti UUID yang sah.',

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
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],

];
