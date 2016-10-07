<?php

namespace Enniel\AmiLog\Models;

use Illuminate\Database\Eloquent\Model;

class Dial extends Model
{
    /**
     * {@inheritdoc}
     */
    public $table = 'ami_log_dial';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'privilege',
        'sub_event',
        'channel',
        'destination',
        'caller_id_num',
        'caller_id_name',
        'unique_id',
        'dest_unique_id',
        'dial_string',
        'dial_status',
    ];
}
