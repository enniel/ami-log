<?php

namespace Enniel\AmiLog\Models;

use Illuminate\Database\Eloquent\Model;

class Agents extends Model
{
    /**
     * {@inheritdoc}
     */
    public $table = 'ami_log_agents';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'status',
        'agent',
        'name',
        'logged_in_chan',
        'logged_in_time',
        'talking_to',
        'talking_to_channel',
    ];
}
