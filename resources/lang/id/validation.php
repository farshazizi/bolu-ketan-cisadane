<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    */

    'accepted' => ':attribute harus diterima.',
    'accepted_if' => ':attribute harus diterima ketika :other bernilai :value.',
    'active_url' => ':attribute bukan URL yang valid.',
    'after' => ':attribute harus berisi tanggal setelah :date.',
    'after_or_equal' => ':attribute harus berisi tanggal setelah atau sama dengan :date.',
    'alpha' => ':attribute hanya boleh berisi huruf.',
    'alpha_dash' => ':attribute hanya boleh berisi huruf, angka, strip, dan garis bawah.',
    'alpha_num' => ':attribute hanya boleh berisi huruf dan angka.',
    'array' => ':attribute harus berupa daftar.',
    'before' => ':attribute harus berisi tanggal sebelum :date.',
    'before_or_equal' => ':attribute harus berisi tanggal sebelum atau sama dengan :date.',
    'between' => [
        'numeric' => ':attribute harus bernilai antara :min sampai :max.',
        'file' => ':attribute harus berukuran antara :min sampai :max kilobita.',
        'string' => ':attribute harus berisi antara :min sampai :max karakter.',
        'array' => ':attribute harus memiliki :min sampai :max item.',
    ],
    'boolean' => ':attribute harus bernilai benar atau salah.',
    'confirmed' => 'Konfirmasi :attribute tidak cocok.',
    'current_password' => 'Kata sandi salah.',
    'date' => ':attribute bukan tanggal yang valid.',
    'date_equals' => ':attribute harus berisi tanggal yang sama dengan :date.',
    'date_format' => ':attribute tidak sesuai dengan format :format.',
    'different' => ':attribute dan :other harus berbeda.',
    'digits' => ':attribute harus terdiri dari :digits angka.',
    'digits_between' => ':attribute harus terdiri dari :min sampai :max angka.',
    'dimensions' => ':attribute memiliki dimensi gambar yang tidak valid.',
    'distinct' => ':attribute memiliki nilai yang duplikat.',
    'email' => ':attribute harus berupa alamat email yang valid.',
    'ends_with' => ':attribute harus diakhiri salah satu dari: :values.',
    'exists' => ':attribute yang dipilih tidak valid.',
    'file' => ':attribute harus berupa berkas.',
    'filled' => ':attribute wajib diisi.',
    'gt' => [
        'numeric' => ':attribute harus lebih besar dari :value.',
        'file' => ':attribute harus berukuran lebih besar dari :value kilobita.',
        'string' => ':attribute harus berisi lebih dari :value karakter.',
        'array' => ':attribute harus memiliki lebih dari :value item.',
    ],
    'gte' => [
        'numeric' => ':attribute harus lebih besar dari atau sama dengan :value.',
        'file' => ':attribute harus berukuran lebih besar dari atau sama dengan :value kilobita.',
        'string' => ':attribute harus berisi :value karakter atau lebih.',
        'array' => ':attribute harus memiliki :value item atau lebih.',
    ],
    'image' => ':attribute harus berupa gambar.',
    'in' => ':attribute yang dipilih tidak valid.',
    'in_array' => ':attribute tidak ada di dalam :other.',
    'integer' => ':attribute harus berupa bilangan bulat.',
    'ip' => ':attribute harus berupa alamat IP yang valid.',
    'ipv4' => ':attribute harus berupa alamat IPv4 yang valid.',
    'ipv6' => ':attribute harus berupa alamat IPv6 yang valid.',
    'json' => ':attribute harus berupa JSON yang valid.',
    'lt' => [
        'numeric' => ':attribute harus kurang dari :value.',
        'file' => ':attribute harus berukuran kurang dari :value kilobita.',
        'string' => ':attribute harus berisi kurang dari :value karakter.',
        'array' => ':attribute harus memiliki kurang dari :value item.',
    ],
    'lte' => [
        'numeric' => ':attribute harus kurang dari atau sama dengan :value.',
        'file' => ':attribute harus berukuran kurang dari atau sama dengan :value kilobita.',
        'string' => ':attribute harus berisi :value karakter atau kurang.',
        'array' => ':attribute tidak boleh memiliki lebih dari :value item.',
    ],
    'max' => [
        'numeric' => ':attribute maksimal bernilai :max.',
        'file' => ':attribute maksimal berukuran :max kilobita.',
        'string' => ':attribute maksimal berisi :max karakter.',
        'array' => ':attribute maksimal memiliki :max item.',
    ],
    'mimes' => ':attribute harus berupa berkas berjenis: :values.',
    'mimetypes' => ':attribute harus berupa berkas berjenis: :values.',
    'min' => [
        'numeric' => ':attribute minimal bernilai :min.',
        'file' => ':attribute minimal berukuran :min kilobita.',
        'string' => ':attribute minimal berisi :min karakter.',
        'array' => ':attribute minimal memiliki :min item.',
    ],
    'multiple_of' => ':attribute harus kelipatan dari :value.',
    'not_in' => ':attribute yang dipilih tidak valid.',
    'not_regex' => 'Format :attribute tidak valid.',
    'numeric' => ':attribute harus berupa angka.',
    'password' => 'Kata sandi salah.',
    'present' => ':attribute wajib ada.',
    'prohibited' => ':attribute tidak boleh diisi.',
    'prohibited_if' => ':attribute tidak boleh diisi ketika :other bernilai :value.',
    'prohibited_unless' => ':attribute tidak boleh diisi kecuali :other bernilai :values.',
    'prohibits' => ':attribute melarang :other untuk diisi.',
    'regex' => 'Format :attribute tidak valid.',
    'required' => ':attribute wajib diisi.',
    'required_if' => ':attribute wajib diisi ketika :other bernilai :value.',
    'required_unless' => ':attribute wajib diisi kecuali :other bernilai :values.',
    'required_with' => ':attribute wajib diisi ketika :values ada.',
    'required_with_all' => ':attribute wajib diisi ketika :values ada.',
    'required_without' => ':attribute wajib diisi ketika :values tidak ada.',
    'required_without_all' => ':attribute wajib diisi ketika tidak ada satu pun dari :values.',
    'same' => ':attribute dan :other harus sama.',
    'size' => [
        'numeric' => ':attribute harus bernilai :size.',
        'file' => ':attribute harus berukuran :size kilobita.',
        'string' => ':attribute harus berisi :size karakter.',
        'array' => ':attribute harus memiliki :size item.',
    ],
    'starts_with' => ':attribute harus diawali salah satu dari: :values.',
    'string' => ':attribute harus berupa teks.',
    'timezone' => ':attribute harus berupa zona waktu yang valid.',
    'unique' => ':attribute sudah digunakan.',
    'uploaded' => ':attribute gagal diunggah.',
    'url' => 'Format :attribute tidak valid.',
    'uuid' => ':attribute harus berupa UUID yang valid.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
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
    | Field names as users see them, so messages read "Ikon harus berupa gambar."
    | instead of "icon harus berupa gambar."
    |
    */

    'attributes' => [
        'name' => 'Nama',
        'price' => 'Harga',
        'minimalQuantity' => 'Minimal kuantitas',
        'category' => 'Kategori',
        'icon' => 'Ikon',
        'removeIcon' => 'Hapus ikon',
        'date' => 'Tanggal',
        'notes' => 'Catatan',
        'status' => 'Status',
        'uom' => 'Satuan',
        'detail' => 'Detail',
        'dailyReportDate' => 'Tanggal',
        'monthlyReportDate' => 'Bulan',
        'orderReportDate' => 'Tanggal',
    ],

];
