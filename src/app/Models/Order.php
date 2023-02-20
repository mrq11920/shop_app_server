<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'status',
        'total_discount',
        'shopping_session_id',
        'user_address_id',
        'created_at',
        'updated_at',
    ];

    public function shoppingSession()
    {
        return $this->belongsTo(ShoppingSession::class, 'shopping_session_id', 'id');
    }

    public function userAddress()
    {
        return $this->belongsTo(UserAddress::class, 'user_address_id', 'id');
    }
}
