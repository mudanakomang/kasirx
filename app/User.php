<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'username', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function role(){
        return $this->belongsTo(Role::class);
    }

    public function hasRole($role){
        return $this->role()->where('name',$role)->count()==1;
    }

    public function transaksiBatal(){
        return $this->hasMany(TransaksiBatal::class);
    }
    public function transaksi(){
        return $this->belongsTo(User::class);
    }
}

