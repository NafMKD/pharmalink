<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditTrail extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'tenant_id','user_id','saas_user_id','action','auditable_type','auditable_id',
        'old_values','new_values','ip_address','user_agent','created_at'
    ];

    protected $casts = [
        'old_values' => 'array',
        'new_values' => 'array',
        'created_at' => 'datetime',
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function saasUser()
    {
        return $this->belongsTo(SaasUser::class, 'saas_user_id');
    }

    public function auditable()
    {
        return $this->morphTo();
    }
}
