<?php

namespace Enniel\AmiLog\Models;

use Illuminate\Database\Eloquent\Model;

class QueueMemberStatus extends Model
{
    /**
     * {@inheritdoc}
     */
    public $table = 'ami_log_queue_member_status';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'privilege',
        'queue',
        'location',
        'member_name',
        'membership',
        'penalty',
        'calls_taken',
        'status',
        'paused',
    ];
}
