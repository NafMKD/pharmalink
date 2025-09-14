<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'tenant_id','phone','role', 'otp', 'is_active','email'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function businesses()
    {
        return $this->hasMany(Business::class);
    }

    public function salesLinks()
    {
        return $this->hasMany(SalespersonLink::class, 'salesperson_id');
    }

    public function messages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function chatsAsBuyer()
    {
        return $this->hasMany(Chat::class, 'buyer_id');
    }

    public function chatsAsSeller()
    {
        return $this->hasMany(Chat::class, 'seller_id');
    }

    public function auditTrails()
    {
        return $this->hasMany(AuditTrail::class);
    }
}
