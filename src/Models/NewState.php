<?php

namespace Enniel\AmiLog\Models;

use Illuminate\Database\Eloquent\Model;

class NewState extends Model
{
    /**
     * {@inheritdoc}
     */
    public $table = 'ami_log_new_state';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'privilege',
        'channel',
        'channel_state',
        'channel_state_desc',
        'caller_id_num',
        'caller_id_name',
        'unique_id',
        'connected_line_num',
        'connected_line_name',
    ];
}
