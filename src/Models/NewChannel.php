<?php

namespace Enniel\AmiLog\Models;

use Illuminate\Database\Eloquent\Model;

class NewChannel extends Model
{
    /**
     * {@inheritdoc}
     */
    public $table = 'ami_log_new_channel';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'privilege',
        'channel',
        'channel_state',
        'channel_state_desc',
        'caller_id_num',
        'caller_id_name',
        'unique_id',
        'account_code',
        'context',
        'extension',
    ];
}
