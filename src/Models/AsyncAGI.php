<?php

namespace Enniel\AmiLog\Models;

use Illuminate\Database\Eloquent\Model;

class AsyncAGI extends Model
{
    /**
     * {@inheritdoc}
     */
    public $table = 'ami_log_async_agi';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'privilege',
        'sub_event',
        'channel',
        'environment',
        'result',
        'command_id',
    ];
}
