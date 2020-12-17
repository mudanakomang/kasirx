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
        Route::post('tambahbarang','InventoryController@simpanBarang')->name('barang.tambah');

        Route::get('jenisbarang','InventoryController@jenisBarang');
        Route::get('jenisbarang/tambah','InventoryController@tambahJenisBarang');
        Route::post('jenisbarang/tambah','InventoryController@simpanJenisBarang')->name('jenisbarang.tambah');
        Route::post('jenisbarang/hapus','InventoryController@hapusJenisBarang')->name('jenisbarang.hapus');
        Route::post('jenisbarang/update','InventoryController@updateJenisBarang')->name('jenisbarang.update');
        Route::get('jenisbarang/edit/{id}','InventoryController@editJenisBarang');
    });

    Route::get('dashboard','DashboardController@index');
});