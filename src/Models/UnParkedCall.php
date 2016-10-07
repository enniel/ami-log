<?php

namespace Enniel\AmiLog\Models;

use Illuminate\Database\Eloquent\Model;

class UnParkedCall extends Model
{
    /**
     * {@inheritdoc}
     */
    public $table = 'ami_log_unparked_call';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'privilege',
        'parking_lot',
        'from',
        'connected_line_num',
        'connected_line_name',
        'channel',
        'caller_id_num',
        'caller_id_name',
        'unique_id',
        'extension',
    ];
}
