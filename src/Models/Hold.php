<?php

namespace Enniel\AmiLog\Models;

use Illuminate\Database\Eloquent\Model;

class Hold extends Model
{
    /**
     * {@inheritdoc}
     */
    public $table = 'ami_log_hold';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'privilege',
        'channel',
        'status',
        'unique_id',
    ];
}
