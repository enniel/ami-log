<?php

namespace Enniel\AmiLog\Models;

use Illuminate\Database\Eloquent\Model;

class QueueMemberPaused extends Model
{
    /**
     * {@inheritdoc}
     */
    public $table = 'ami_log_queue_member_paused';

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
        'paused',
    ];
}
