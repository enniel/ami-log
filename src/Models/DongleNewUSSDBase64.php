<?php

namespace Enniel\AmiLog\Models;

use Illuminate\Database\Eloquent\Model;

class DongleNewUSSDBase64 extends Model
{
    /**
     * {@inheritdoc}
     */
    public $table = 'ami_log_dongle_new_ussd_base64';

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
