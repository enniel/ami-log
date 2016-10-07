<?php

namespace Enniel\AmiLog\Models;

use Illuminate\Database\Eloquent\Model;

class AgentLogoff extends Model
{
    /**
     * {@inheritdoc}
     */
    public $table = 'ami_log_agent_logoff';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'privilege',
        'agent',
        'unique_id',
        'login_time',
    ];
}
