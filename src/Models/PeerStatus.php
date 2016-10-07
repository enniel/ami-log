<?php

namespace Enniel\AmiLog\Models;

use Illuminate\Database\Eloquent\Model;

class PeerStatus extends Model
{
    /**
     * {@inheritdoc}
     */
    public $table = 'ami_log_peer_status';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'channel_type',
        'privilege',
        'peer',
        'peer_status',
        'address',
    ];
}
