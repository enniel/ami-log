<?php

namespace Enniel\AmiLog\Models;

use Illuminate\Database\Eloquent\Model;

class RTPSenderStat extends Model
{
    /**
     * {@inheritdoc}
     */
    public $table = 'ami_log_rtp_sender_stat';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'privilege',
        'ssrc',
        'sent_packets',
        'lost_packets',
        'jitter',
        'rtt',
        'sr_count',
    ];
}
