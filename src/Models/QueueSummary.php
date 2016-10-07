<?php

namespace Enniel\AmiLog\Models;

use Illuminate\Database\Eloquent\Model;

class QueueSummary extends Model
{
    /**
     * {@inheritdoc}
     */
    public $table = 'ami_log_queue_summary';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'queue',
        'logged_in',
        'available',
        'callers',
        'hold_time',
        'longest_hold_time',
    ];
}
