<?php

namespace Enniel\AmiLog\Models;

use Illuminate\Database\Eloquent\Model;

class AgentComplete extends Model
{
    /**
     * {@inheritdoc}
     */
    public $table = 'ami_log_agent_complete';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'privilege',
        'queue',
        'unique_id',
        'channel',
        'member',
        'member_name',
        'hold_time',
        'talk_time',
        'reason',
    ];
}
