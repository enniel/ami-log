<?php

namespace Enniel\AmiLog\Models;

use Illuminate\Database\Eloquent\Model;

class AgentConnect extends Model
{
    /**
     * {@inheritdoc}
     */
    public $table = 'ami_log_agent_connect';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'privilege',
        'hold_time',
        'bridged_channel',
        'ring_time',
        'member',
        'member_name',
        'queue',
        'unique_id',
        'channel',
    ];
}
