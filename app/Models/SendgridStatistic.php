<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SendgridStatistic extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'timestamp',
        'event',
        'sg_machine_open',
        'category',
        'sg_event_id',
        'sg_message_id',
        'useragent',
        'ip',
    ];
}
