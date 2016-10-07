<?php

namespace Enniel\AmiLog\Models;

use Illuminate\Database\Eloquent\Model;

class QueueMemberAdded extends Model
{
    /**
     * {@inheritdoc}
     */
    public $table = 'ami_log_queue_member_added';

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
        'last_call',
        'status',
        'paused',
    ];
}
