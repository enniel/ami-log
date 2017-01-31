<?php

namespace Enniel\AmiLog\Models;

use Illuminate\Database\Eloquent\Model;

class DonglePortFail extends Model
{
    /**
     * {@inheritdoc}
     */
    public $table = 'ami_dongle_port_fail';

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
