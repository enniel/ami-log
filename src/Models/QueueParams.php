<?php

namespace Enniel\AmiLog\Models;

use Illuminate\Database\Eloquent\Model;

class QueueParams extends Model
{
    /**
     * {@inheritdoc}
     */
    public $table = 'ami_log_queue_params';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'queue',
        'max',
        'strategy',
        'calls',
        'hold_time',
        'completed',
        'abandoned',
        'service_level',
        'service_level_perf',
        'weight',
    ];
}
