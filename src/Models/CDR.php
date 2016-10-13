<?php

namespace Enniel\AmiLog\Models;

use Illuminate\Database\Eloquent\Model;

class CDR extends Model
{
    /**
     * {@inheritdoc}
     */
    public $table = 'ami_log_cdr';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'privilege',
        'account_code',
        'source',
        'destination',
        'destination_context',
        'caller_id',
        'channel',
        'destination_channel',
        'last_application',
        'last_data',
        'start_time',
        'answer_time',
        'end_time',
        'duration',
        'billable_seconds',
        'disposition',
        'ama_flags',
        'unique_id',
        'user_field',
        'rate',
        'carrier',
    ];
}
