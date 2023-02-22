<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    const OPEN = 1;
    const DELIVERING = 2;
    const RECEIVED = 3;
    const CANCELLED = 4;

    protected $fillable = [
        'status',
        'user_id',
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
        return $this->belongsTo(UserAddress::class, 'user_address_id', 'id')->withTrashed();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
