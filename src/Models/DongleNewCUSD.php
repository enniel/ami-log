<?php

namespace Enniel\AmiLog\Models;

use Illuminate\Database\Eloquent\Model;

class DongleNewCUSD extends Model
{
    /**
     * {@inheritdoc}
     */
    public $table = 'ami_log_dongle_new_cusd';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'privilege',
        'device',
        'message',
    ];
}
