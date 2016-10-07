<?php

namespace Enniel\AmiLog\Models;

use Illuminate\Database\Eloquent\Model;

class DongleNewUSSD extends Model
{
    /**
     * {@inheritdoc}
     */
    public $table = 'ami_log_dongle_new_ussd';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'privilege',
        'device',
        'line_count',
    ];
}
