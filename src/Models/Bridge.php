<?php

namespace Enniel\AmiLog\Models;

use Illuminate\Database\Eloquent\Model;

class Bridge extends Model
{
    /**
     * {@inheritdoc}
     */
    public $table = 'ami_log_bridge';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'privilege',
        'bridge_state',
        'bridge_type',
        'channel_first',
        'channel_second',
        'caller_id_first',
        'caller_id_second',
        'unique_id_first',
        'unique_id_second',
    ];
}
