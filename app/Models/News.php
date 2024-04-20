<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    protected $fillable = ['Titre', 'Contenu', 'category_id', 'Date_debut', 'Date_expiration'];


    function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
