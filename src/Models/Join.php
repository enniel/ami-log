<?php

namespace Enniel\AmiLog\Models;

use Illuminate\Database\Eloquent\Model;

class Join extends Model
{
    /**
     * {@inheritdoc}
     */
    public $table = 'ami_log_join';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'privilege',
        'channel',
        'count',
        'queue',
        'position',
        'caller_id_num',
        'caller_id_name',
        'connected_line_num',
        'connected_line_name',
        'unique_id',
    ];
}
