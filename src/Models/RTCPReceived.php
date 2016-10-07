<?php

namespace Enniel\AmiLog\Models;

use Illuminate\Database\Eloquent\Model;

class RTCPReceived extends Model
{
    /**
     * {@inheritdoc}
     */
    public $table = 'ami_log_rtcp_received';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'privilege',
        'from',
        'pt',
        'reception_reports',
        'sender_ssrc',
        'fraction_lost',
        'packets_lost',
        'highest_sequence',
        'sequence_number_cycles',
        'ia_jitter',
        'last_sr',
        'dlsr',
        'rtt',
    ];
}
