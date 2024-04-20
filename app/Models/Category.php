<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['name', 'parent_id'];

    function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    function news()
    {
        return $this->hasMany(News::class, 'category_id');
    }
}
