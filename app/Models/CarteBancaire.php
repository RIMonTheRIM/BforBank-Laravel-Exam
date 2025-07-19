<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarteBancaire extends Model
{
    use HasFactory;
    protected $table = 'cartebancaires';
    public function compteBancaire(){
        return $this->belongsTo(CompteBancaire::class,'comptebancaire_id');
    }
}
