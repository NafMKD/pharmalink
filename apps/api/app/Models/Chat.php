<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Chat extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'buyer_id','seller_id','product_id','buyer_unread','seller_unread',
        'last_message_preview','last_message_at','is_archived'
    ];

    protected $casts = [
        'buyer_unread' => 'integer',
        'seller_unread' => 'integer',
        'last_message_at' => 'datetime',
        'is_archived' => 'boolean',
    ];

    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}
