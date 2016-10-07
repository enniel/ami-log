<?php

namespace Enniel\AmiLog\Models;

use Illuminate\Database\Eloquent\Model;

class ChannelUpdate extends Model
{
    /**
     * {@inheritdoc}
     */
    public $table = 'ami_log_channel_update';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'privilege',
        'channel',
        'channel_type',
        'sip_call_id',
        'sip_full_contact',
        'unique_id',
    ];
}
