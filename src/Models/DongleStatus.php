<?php

namespace Enniel\AmiLog\Models;

use Illuminate\Database\Eloquent\Model;

class DongleStatus extends Model
{
    /**
     * {@inheritdoc}
     */
    public $table = 'ami_log_dongle_status';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'privilege',
        'device',
        'status',
    ];
}
