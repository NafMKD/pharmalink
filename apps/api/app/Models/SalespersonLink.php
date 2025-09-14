<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SalespersonLink extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'tenant_id','salesperson_id','business_id','status','requested_by','approved_by','approved_at'
    ];

    protected $casts = [
        'approved_at' => 'datetime',
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function salesperson()
    {
        return $this->belongsTo(User::class, 'salesperson_id');
    }

    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    public function requestedBy()
    {
        return $this->belongsTo(User::class, 'requested_by');
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function moderations()
    {
        return $this->morphMany(Moderation::class, 'reference');
    }
}
