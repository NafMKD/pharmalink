<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MessageAttachment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['message_id','file_path','file_type','file_size'];

    protected $casts = [
        'file_size' => 'integer',
    ];

    public function message()
    {
        return $this->belongsTo(Message::class);
    }
}
