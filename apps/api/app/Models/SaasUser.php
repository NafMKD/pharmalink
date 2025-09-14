<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class SaasUser extends Authenticatable
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name','email','password','phone','role','is_active'];

    protected $hidden = ['password'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function auditTrails()
    {
        return $this->hasMany(AuditTrail::class, 'saas_user_id');
    }
}
