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
    return redirect('dashboard');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware'=>['auth','roles']],function(){
    Route::group(['prefix'=>'admin','roles'=>['admin']],function(){
        Route::get('inventory','InventoryController@index');
        Route::get('tambahbarang','InventoryController@tambahBarang');
        Route::post('updatestok','InventoryController@updateStok')->name('stok.update');
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
        Route::get('paket/tambah','PaketController@tambahPaket');
        Route::post('paket/tambah','PaketController@simpanPaket')->name('paket.tambah');
        Route::get('paket/detail/{id}','PaketController@detail');
        Route::get('paket/edit/{id}','PaketController@edit');
        Route::post('paket/update','PaketController@update')->name('paket.update');
        Route::post('paket/item/hapus','PaketController@hapusItem')->name('item.hapus');
        Route::post('paket/item/tambah','PaketController@tambahItem')->name('item.tambah');
        Route::post('paket/item/update','PaketController@updateItem')->name('item.update');

        Route::get('konfig','KonfigurasiController@index');
        Route::post('konfig/update','KonfigurasiController@update')->name('konfig.update');
    });

    Route::get('transaksi','TransaksiController@index');
    Route::get('transaksi/tambah','TransaksiController@tambahTransaksi');
    Route::get('transaksi/detail/{id}','TransaksiController@detail');
    Route::post('transaksi/cetak','PrintController@cetakTrx')->name('trx.cetak');
    Route::post('transaksi/cek','TransaksiController@cekTrx')->name('trx.cek');
    Route::post('transaksi/tambah','TransaksiController@saveTrx')->name('trx.tambah');
    Route::post('transaksi/simpan','TransaksiController@simpanTrx')->name('trx.simpan');
    Route::post('transaksi/item/tambah','TransaksiController@itemAddTrx')->name('trx.item.add');
    Route::post('transaksi/item/update','TransaksiController@itemUpdateTrx')->name('trx.item.update');
    Route::post('transaksi/item/delete','TransaksiController@itemDeleteTrx')->name('trx.item.delete');
    Route::post('transaksi/delete','TransaksiController@deleteTrx')->name('trx.hapus');
    Route::post('transaksi/batal','TransaksiController@batalTrx')->name('trx.batal');
    Route::get('dashboard','DashboardController@index');
    Route::get('profil','DashboardController@profil');
    Route::post('profil/update','PegawaiController@profilUpdate')->name('profil.update');

    Route::get('customer','CustomerController@index');
    Route::get('customer/tambah','CustomerController@tambah');
    Route::post('customer/tambah','CustomerController@simpan')->name('customer.tambah');
    Route::post('customer/hapus','CustomerController@hapus')->name('customer.hapus');
    Route::post('customer/update','CustomerController@update')->name('customer.update');
});