<?php

namespace Enniel\AmiLog\Models;

use Illuminate\Database\Eloquent\Model;

class AgentLogin extends Model
{
    /**
     * {@inheritdoc}
     */
    public $table = 'ami_log_agent_login';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'privilege',
        'agent',
        'unique_id',
        'channel',
    ];
}
