<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'merchant_id',
        'price',
        'unit_type',
        'quantity',
        'discount_id',
        'category_id',
        'province_id',
        'status',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function images() 
    {
        return $this->morphMany(Image::class, 'imageable');
    }
}
