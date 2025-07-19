<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompteBancaire extends Model
{
    use HasFactory;
    protected $table = 'comptebancaires';
    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'comptebancaire_id');
    }
    public function demandes()
    {
        return $this->hasMany(Demande::class, 'comptebancaire_id');
    }
    public function carteBancaire()
    {
        return $this->hasOne(CarteBancaire::class, 'comptebancaire_id');
    }
    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
