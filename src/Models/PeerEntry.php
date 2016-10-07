<?php

namespace Enniel\AmiLog\Models;

use Illuminate\Database\Eloquent\Model;

class PeerEntry extends Model
{
    /**
     * {@inheritdoc}
     */
    public $table = 'ami_log_peer_entry';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'channel_type',
        'object_name',
        'chan_object_type',
        'ip_address',
        'ip_port',
        'dynamic',
        'nat_support',
        'video_support',
        'text_support',
        'acl',
        'status',
        'realtime_device',
    ];
}
