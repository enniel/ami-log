<?php

namespace Enniel\AmiLog\Models;

use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    /**
     * {@inheritdoc}
     */
    public $table = 'ami_log_leave';

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
        'unique_id',
    ];
}
