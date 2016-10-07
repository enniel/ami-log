<?php

namespace Enniel\AmiLog\Models;

use Illuminate\Database\Eloquent\Model;

class CoreShowChannel extends Model
{
    /**
     * {@inheritdoc}
     */
    public $table = 'ami_log_core_show_channel';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'privilege',
        'channel',
        'unique_id',
        'context',
        'extension',
        'priority',
        'channel_state',
        'channel_state_desc',
        'application',
        'application_data',
        'caller_id_num',
        'duration',
        'account_code',
        'bridged_channel',
        'bridged_unique_id'
    ];
}
