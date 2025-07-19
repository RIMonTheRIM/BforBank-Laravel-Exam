<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    public function comptebancaire(){
        return $this->belongsTo(CompteBancaire::class, 'comptebancaire_id');
    }
    protected $fillable = [
        'type',
        'montant','date_transaction','comptebancaire_id','compte_dest_id'
    ];
}
