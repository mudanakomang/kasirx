<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Konfigurasi extends Model
{
    //
    protected $table='konfigurasi';
    protected  $fillable=['nama','alamat','nohp','email','printer','footnote'];


}
