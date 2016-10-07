<?php

namespace Enniel\AmiLog\Models;

use Illuminate\Database\Eloquent\Model;

class AGIExec extends Model
{
    /**
     * {@inheritdoc}
     */
    public $table = 'ami_log_agi_exec';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'privilege',
        'sub_event',
        'channel',
        'command',
        'command_id',
        'result',
        'result_code',
    ];
}
