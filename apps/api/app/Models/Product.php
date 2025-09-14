<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'tenant_id','business_id','posted_by','category_id','name','brand','unit',
        'price','available_quantity','location','description','expiry_date',
        'serial_number','manufacturer','batch_number','is_active','is_flagged'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'available_quantity' => 'integer',
        'expiry_date' => 'date',
        'is_active' => 'boolean',
        'is_flagged' => 'boolean',
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    public function postedBy()
    {
        return $this->belongsTo(User::class, 'posted_by');
    }

    public function category()
    {
        return $this->belongsTo(ProductCategory::class);
    }

    public function chats()
    {
        return $this->hasMany(Chat::class);
    }

    public function moderations()
    {
        return $this->morphMany(Moderation::class, 'reference');
    }
}
