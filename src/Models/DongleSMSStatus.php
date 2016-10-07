<?php

namespace Enniel\AmiLog\Models;

use Illuminate\Database\Eloquent\Model;

class DongleSMSStatus extends Model
{
    /**
     * {@inheritdoc}
     */
    public $table = 'ami_log_dongle_sms_status';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'privilege',
        'device',
        'sms_id',
        'status',
    ];
}
