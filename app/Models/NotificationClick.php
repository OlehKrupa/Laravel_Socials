<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationClick extends Model
{
    use HasFactory;

    protected $fillable = [
        'notifiable_id',
        'link',
        'timestamp',
    ];

    public function notifiable()
    {
        return $this->belongsTo('App\Models\User', 'notifiable_id');
    }
}
