<?php

namespace Enniel\AmiLog\Models;

use Illuminate\Database\Eloquent\Model;

class RTPReceiverStat extends Model
{
    /**
     * {@inheritdoc}
     */
    public $table = 'ami_log_rtp_receiver_stat';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'privilege',
        'ssrc',
        'received_packets',
        'lost_packets',
        'jitter',
        'transit',
        'rr_count',
    ];
}
