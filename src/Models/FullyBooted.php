<?php

namespace Enniel\AmiLog\Models;

use Illuminate\Database\Eloquent\Model;

class FullyBooted extends Model
{
    /**
     * {@inheritdoc}
     */
    public $table = 'ami_log_fully_booted';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'privilege',
        'status',
    ];
}
