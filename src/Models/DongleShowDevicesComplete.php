<?php

namespace Enniel\AmiLog\Models;

use Illuminate\Database\Eloquent\Model;

class DongleShowDevicesComplete extends Model
{
    /**
     * {@inheritdoc}
     */
    public $table = 'ami_log_dongle_show_devices_complete';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'list_items',
    ];
}
