<?php

namespace Enniel\AmiLog\Models;

use Illuminate\Database\Eloquent\Model;

class Hangup extends Model
{
    /**
     * {@inheritdoc}
     */
    public $table = 'ami_log_hangup';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'privilege',
        'channel',
        'caller_id_num',
        'caller_id_name',
        'unique_id',
        'cause',
        'cause_text',
    ];
}
