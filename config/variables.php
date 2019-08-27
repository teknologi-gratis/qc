<?php

return [
    
    'boolean' => [
        '0' => 'No',
        '1' => 'Yes',
    ],

    'role' => [
        '10' => 'Admin',
        '15' => 'Admin Lembaga Survey',
        '20' => 'Saksi TPS'

    ],
    
    'status' => [
        'aktif' => 'Aktif',
        'non_aktif' => 'Tidak Aktif'
    ],

    'jenis' => [
        '1' => 'Perorangan',
        '2' => 'Lembaga'
    ],

    'jenis_pil' => [
        'gubernur' => 'Gubernur',
        'walikota' => 'Walikota',
        'bupati' => 'Bupati'
    ],

    'avatar' => [
        'public' => '/storage/avatar/',
        'folder' => 'avatar',
        
        'width'  => 400,
        'height' => 400,
    ],

    /*
    |------------------------------------------------------------------------------------
    | ENV of APP
    |------------------------------------------------------------------------------------
    */
    'APP_ADMIN' => 'admin',
    'APP_TOKEN' => env('APP_TOKEN', 'admin123456'),
];
