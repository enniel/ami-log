<?php

namespace Enniel\AmiLog\Models;

use Illuminate\Database\Eloquent\Model;

class CEL extends Model
{
    /**
     * {@inheritdoc}
     */
    public $table = 'ami_log_cel';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'ama_flags',
        'account_code',
        'app_data',
        'application',
        'caller_id_ani',
        'caller_id_dnid',
        'caller_id_name',
        'caller_id_num',
        'caller_id_rdnis',
        'channel',
        'context',
        'event',
        'event_name',
        'event_time',
        'exten',
        'extra',
        'linked_id',
        'peer',
        'peer_account',
        'privilege',
        'timestamp',
        'unique_id',
        'user_field',
    ];
}
