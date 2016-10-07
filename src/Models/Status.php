<?php

namespace Enniel\AmiLog\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    /**
     * {@inheritdoc}
     */
    public $table = 'ami_log_status';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'bridged_unique_id',
        'privilege',
        'channel',
        'context',
        'extension',
        'unique_id',
        'priority',
        'channel_state',
        'channel_state_desc',
        'application',
        'application_data',
        'caller_id_num',
        'duration',
        'account_code',
        'seconds',
        'bridged_channel',
    ];
}
