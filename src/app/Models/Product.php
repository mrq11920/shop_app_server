<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'desc',
        'image_url',
        'unit_type',
        'price',
        'quantity',
        'category_id',
        'created_at',
        'updated_at',
    ];

    public function category() 
    {
        return $this->belongsTo(Category::class);
    }
}
