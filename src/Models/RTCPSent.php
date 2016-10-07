<?php

namespace Enniel\AmiLog\Models;

use Illuminate\Database\Eloquent\Model;

class RTCPSent extends Model
{
    /**
     * {@inheritdoc}
     */
    public $table = 'ami_log_rtcp_sent';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'privilege',
        'to',
        'our_ssrc',
        'sent_ntp',
        'sent_rtp',
        'sent_packets',
        'sent_octets',
        'report_block',
        'fraction_lost',
        'cumulative_loss',
        'ia_jitter',
        'their_last_sr',
        'dlsr',
    ];
}
