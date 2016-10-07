<?php

namespace Enniel\AmiLog\Models;

use Illuminate\Database\Eloquent\Model;

class AgentCalled extends Model
{
    /**
     * {@inheritdoc}
     */
    public $table = 'ami_log_agent_called';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'privilege',
        'queue',
        'agent_called',
        'agent_name',
        'channel_calling',
        'destination_channel',
        'caller_id_num',
        'caller_id_name',
        'connected_line_num',
        'connected_line_name',
        'context',
        'extension',
        'priority',
        'unique_id'
    ];
}
