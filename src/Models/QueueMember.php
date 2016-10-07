<?php

namespace Enniel\AmiLog\Models;

use Illuminate\Database\Eloquent\Model;

class QueueMember extends Model
{
    /**
     * {@inheritdoc}
     */
    public $table = 'ami_log_queue_member';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'queue',
        'location',
        'name',
        'membership',
        'penalty',
        'calls_taken',
        'status',
        'paused',
    ];
}
