<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Moderation extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'tenant_id','type','reference_id','status','action_by','action_at','reason'
    ];

    protected $casts = [
        'action_at' => 'datetime',
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function actionBy()
    {
        return $this->belongsTo(User::class, 'action_by');
    }
}
