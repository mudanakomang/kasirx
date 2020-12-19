<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware'=>['auth','roles']],function(){
    Route::group(['prefix'=>'admin','roles'=>['admin']],function(){
        Route::get('inventory','InventoryController@index');
        Route::get('tambahbarang','InventoryController@tambahBarang');
        Route::get('barang/edit/{id}','InventoryController@editBarang');
        Route::post('tambahbarang','InventoryController@simpanBarang')->name('barang.tambah');
        Route::post('hapusbarang','InventoryController@hapusBarang')->name('barang.hapus');
        Route::post('updatebarang','InventoryController@updateBarang')->name('barang.update');

        Route::get('jenisbarang','InventoryController@jenisBarang');
        Route::get('jenisbarang/tambah','InventoryController@tambahJenisBarang');
        Route::post('jenisbarang/tambah','InventoryController@simpanJenisBarang')->name('jenisbarang.tambah');
        Route::post('jenisbarang/hapus','InventoryController@hapusJenisBarang')->name('jenisbarang.hapus');
        Route::post('jenisbarang/update','InventoryController@updateJenisBarang')->name('jenisbarang.update');
        Route::get('jenisbarang/edit/{id}','InventoryController@editJenisBarang');

        Route::get('pegawai','PegawaiController@index');
        Route::get('pegawai/tambah','PegawaiController@tambahPegawai');
        Route::get('pegawai/edit/{id}','PegawaiController@editPegawai');
        Route::post('pegawai/tambah','PegawaiController@simpanPegawai')->name('pegawai.tambah');
        Route::post('pegawai/update','PegawaiController@updatePegawai')->name('pegawai.update');
        Route::post('pegawai/hapus','PegawaiController@hapusPegawai')->name('pegawai.hapus');

        Route::get('user/edit/{id}','PegawaiController@editUser');
        Route::get('user/tambah','PegawaiController@tambahUser');
        Route::post('user/update','PegawaiController@updateUser')->name('user.update');
        Route::post('user/tambah','PegawaiController@simpanUser')->name('user.tambah');
        Route::post('user/hapus','PegawaiController@hapusUser')->name('user.hapus');

        Route::get('paket','PaketController@index');
        Route::get('paket/detail/{id}','PaketController@detail');
        Route::post('paket/item/hapus','PaketController@hapusItem')->name('item.hapus');
        Route::post('paket/item/tambah','PaketController@tambahItem')->name('item.tambah');
    });

    Route::get('dashboard','DashboardController@index');
});