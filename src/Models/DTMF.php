<?php

namespace Enniel\AmiLog\Models;

use Illuminate\Database\Eloquent\Model;

class DTMF extends Model
{
    /**
     * {@inheritdoc}
     */
    public $table = 'ami_log_dtmf';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'privilege',
        'channel',
        'digit',
        'direction',
        'end',
        'begin',
        'unique_id',
    ];
}
