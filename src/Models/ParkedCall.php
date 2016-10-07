<?php

namespace Enniel\AmiLog\Models;

use Illuminate\Database\Eloquent\Model;

class ParkedCall extends Model
{
    /**
     * {@inheritdoc}
     */
    public $table = 'ami_log_parked_call';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'privilege',
        'parking_lot',
        'from',
        'timeout',
        'connected_line_num',
        'connected_line_name',
        'channel',
        'caller_id_num',
        'caller_id_name',
        'unique_id',
        'extension',
    ];
}
