<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plant extends Model
{
    use HasFactory;
    protected $fillable = [
        'name','picture','price','description','categorie_id','user_id'
    ];

    function categories(){
        return $this->belongsToMany(Categorie::class)
        ->withTimestamps()
        ->as('plant_categorie');
    }
}
