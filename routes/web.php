<?php

Route::get('/', function(){
    return view('index');
});

Route::get('/login', '\App\Http\Controllers\Auth\LoginController@login')->name('lembaga_login');
Route::get('/super', '\App\Http\Controllers\Auth\LoginSuperController@showLogin')->name('super_login');
Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');
Route::get('logout', '\App\Http\Controllers\Auth\LoginSuperController@logout');
Route::get('/password/reset', 'App\Http\Controllers\Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('/password/email', 'App\Http\Controllers\Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
//Route::post('super', [ 'as' => 'login', 'uses' => 'LoginSuperController@login']);

Auth::routes();

Route::get('/registrasi_lembaga', 'Auth\RegisterLembagaController@index');
Route::post('/registrasi_lembaga_proses', 'Auth\RegisterLembagaController@create')->name('registrasi_lembaga_proses');
Route::get('/registrasi_akun/{id}', 'Auth\RegisterAkunController@index');
Route::post('/registrasi_akun_proses', 'Auth\RegisterAkunController@create')->name('registrasi_akun_proses');

Route::get('/rekapitulasi_suara', 'Admin_lembaga\RekapitulasiController@index')->name('rekapitulasi.index');

// Ajax rekapitulasi
Route::get('ajax/kabupaten/{id}', 'Auth\RegisterLembagaController@getKabupaten')->name('ajax.kabupaten');
Route::get('ajax/kecamatan/{id}', 'Auth\RegisterLembagaController@getKecamatan')->name('ajax.kecamatan');
Route::get('ajax/kelurahan/{id}', 'Auth\RegisterLembagaController@getKelurahan')->name('ajax.kelurahan');
Route::post('rekapitulasi/ajax/filter', 'Admin_lembaga\RekapitulasiController@filter')->name('ajax.filter');

/*
|------------------------------------------------------------------------------------
| Admin
|------------------------------------------------------------------------------------
*/
Route::group(['prefix' => ADMIN, 'as' => ADMIN . '.', 'middleware'=>['auth', 'Role:10']], function () {
    Route::get('/', 'DashboardController@index')->name('dash');
    Route::resource('users', 'UserController');
    Route::resource('lembaga', 'LembagaController');
    Route::resource('pemilihan', 'PemilihanController');
    Route::resource('tps', 'TpsController');
    Route::get('lembaga/data/{id}', 'GabunganController@index')->name('lembaga');
    Route::get('/rekapitulasi_suara', 'RekapitulasiController@index')->name('rekapitulasi.index');
    Route::post('/rekapitulasi/ajax/filter', 'RekapitulasiController@filter')->name('rekapitulasi.filter');


    //import
    Route::post('users/import_excel','UserController@import_excel');
    Route::post('tps/import_excel','TpsController@tps_import');

    //import saksi & tps lembaga
    // Route::post('saksi/import_excel','SaksiLembagaController@import_excel');
    // Route::post('tps/import_excel','TpsLembagaController@tpss_import');

    Route::get('pemilihan/calon/{id}', 'CalonController@index');
    Route::get('pemilihan/calon/create/{id}', 'CalonController@create');
    Route::post('pemilihan/calon/', 'CalonController@store');
    Route::get('pemilihan/calon/edit/{id}', 'CalonController@edit');
    // Route::get('pemilihan/calon/edit/{id}', function($id){
    //     dd($id);
    // });
    Route::put('pemilihan/calon/{id}', 'CalonController@update');
    Route::delete('pemilihan/calon/{id}', 'CalonController@destroy');


    //Pemilihan Tiap Lembaga
    // Route::get('lembaga/pemilihan/{id}', 'PemilihanLembagaController@index');
    // Route::get('lembaga/pemilihan/create/{id}', 'PemilihanLembagaController@create');
    // Route::post('lembaga/pemilihan/', 'PemilihanLembagaController@store');
    // Route::get('lembaga/pemilihan/edit/{id}', 'PemilihanLembagaController@edit');
    // Route::put('lembaga/pemilihan/{id}', 'PemilihanLembagaController@update');
    // Route::delete('lembaga/pemilihan/{id}', 'PemilihanLembagaController@destroy');


    //Saksi Tiap Lembaga
    // Route::get('lembaga/saksi/{id}', 'SaksiLembagaController@index');
    // Route::get('lembaga/saksi/create/{id}', 'SaksiLembagaController@create');
    // Route::post('lembaga/saksi/', 'SaksiLembagaController@store');
    // Route::get('lembaga/saksi/edit/{id}', 'SaksiLembagaController@edit');
    // Route::put('lembaga/saksi/{id}', 'SaksiLembagaController@update');
    // Route::delete('lembaga/saksi/{id}', 'SaksiLembagaController@destroy');


    //TPS Tiap Lembaga
    // Route::get('lembaga/tps/{id}', 'TpsLembagaController@index')->name('tps_lembaga');
    // Route::get('lembaga/tps/create/{id}', 'TpsLembagaController@create');
    // Route::post('lembaga/tps/', 'TpsLembagaController@store');
    // Route::get('lembaga/tps/edit/{id}', 'TpsLembagaController@edit');
    // Route::put('lembaga/tps/{id}', 'TpsLembagaController@update');
    // Route::delete('lembaga/tps/{id}', 'TpsLembagaController@destroy');
});

/*
|------------------------------------------------------------------------------------
| Admin Lembaga
|------------------------------------------------------------------------------------
*/
Route::group(['prefix' => 'admin_lembaga', 'as' => 'admin_lembaga.', 'middleware'=>['auth', 'Role:15']], function () {
    Route::get('/', 'Admin_lembaga\DashboardController@index')->name('dash');
    Route::resource('users', 'Admin_lembaga\UserController');
    Route::get('/profil', 'Admin_lembaga\ProfilLembagaController@index')->name('profil');
    Route::resource('pemilihan', 'Admin_lembaga\PemilihanController');
    // Route::resource('saksi', 'Admin_lembaga\SaksiPemilihanController');
    Route::resource('tps', 'Admin_lembaga\TpsController');
    Route::post('/generateSample', 'Admin_lembaga\TpsController@generateSample');

    //import
    Route::post('users/import_excel','Admin_lembaga\UserController@import_excel');
    Route::post('tps/import_excel','Admin_lembaga\TpsController@tps_import');
    //import pemilihan
    Route::post('saksi/import_excel','Admin_lembaga\SaksiPemilihanController@import_excel');
    Route::post('tpspem/import_excel','Admin_lembaga\TpsPemilihanController@tpss_import');
});

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/lembaga-index', 'LembagaController@index')->name('lembaga');
Route::post('/lembaga-create', 'LembagaController@create')->name('lembaga');
Route::get('/lembaga-pemilihan', 'Admin_lembaga\PemilihanController@index')->name('admin_lembaga\pemilihan');

//route calon
Route::get('admin_lembaga/pemilihan/calon/{id}', 'Admin_lembaga\CalonController@index');
Route::get('admin_lembaga/pemilihan/calon/create/{id}', 'Admin_lembaga\CalonController@create');
Route::post('admin_lembaga/pemilihan/calon/', 'Admin_lembaga\CalonController@store');
Route::get('admin_lembaga/pemilihan/calon/edit/{id}', 'Admin_lembaga\CalonController@edit');
Route::put('admin_lembaga/pemilihan/calon/{id}', 'Admin_lembaga\CalonController@update');
Route::delete('admin_lembaga/pemilihan/calon/{id}', 'Admin_lembaga\CalonController@destroy');
//route saksi setiap pemilihan
Route::get('admin_lembaga/pemilihan/saksi/{id}', 'Admin_lembaga\SaksiPemilihanController@index');
Route::get('admin_lembaga/pemilihan/saksi/create/{id}', 'Admin_lembaga\SaksiPemilihanController@create');
Route::post('admin_lembaga/pemilihan/saksi/', 'Admin_lembaga\SaksiPemilihanController@store');
Route::get('admin_lembaga/pemilihan/saksi/edit/{id}', 'Admin_lembaga\SaksiPemilihanController@edit');
Route::put('admin_lembaga/pemilihan/saksi/{id}', 'Admin_lembaga\SaksiPemilihanController@update');
Route::delete('admin_lembaga/pemilihan/saksi/{id}', 'Admin_lembaga\SaksiPemilihanController@destroy');
//route tps setiap pemilihan
Route::get('admin_lembaga/pemilihan/tps/{id}', 'Admin_lembaga\TpsPemilihanController@index')->name('tpsPemilihan');
Route::get('admin_lembaga/pemilihan/tps/create/{id}', 'Admin_lembaga\TpsPemilihanController@create');
Route::post('admin_lembaga/pemilihan/tps/', 'Admin_lembaga\TpsPemilihanController@store');
Route::get('admin_lembaga/pemilihan/tps/edit/{id}', 'Admin_lembaga\TpsPemilihanController@edit');
Route::put('admin_lembaga/pemilihan/tps/{id}', 'Admin_lembaga\TpsPemilihanController@update');
Route::post('admin_lembaga/pemilihan/{id}', 'Admin_lembaga\PemilihanController@update');
Route::delete('admin_lembaga/pemilihan/tps/{id}', 'Admin_lembaga\TpsPemilihanController@destroy');
Route::post('/generateSample', 'Admin_lembaga\TpsPemilihanController@generateSample');
// coba generate
Route::post('/generate-sample', 'Admin_lembaga\TpsPemilihanController@generate');

Route::post('get_kabupaten_by_provinsi', 'DaerahController@getKabupatenByProvinsi');
Route::post('get_kecamatan_by_kabupaten', 'DaerahController@getKecamatanByKabupaten');
Route::post('get_kelurahan_by_kecamatan', 'DaerahController@getKelurahanByKecamatan');

//rekapitulasi
Route::post('get_rekapitulasi', 'RekapitulasiController@rekapitulasi');
Route::get('/save/{id}', ['as' => 'gambar.download', 'uses' => 'Admin_lembaga\TpsController@downloadImage']);
