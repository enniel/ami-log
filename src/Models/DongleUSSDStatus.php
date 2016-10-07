<?php

namespace Enniel\AmiLog\Models;

use Illuminate\Database\Eloquent\Model;

class DongleUSSDStatus extends Model
{
    /**
     * {@inheritdoc}
     */
    public $table = 'ami_log_dongle_ussd_status';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'privilege',
        'device',
        'ussd_id',
        'status',
    ];
}
