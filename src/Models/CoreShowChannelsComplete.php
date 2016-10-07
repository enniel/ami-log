<?php

namespace Enniel\AmiLog\Models;

use Illuminate\Database\Eloquent\Model;

class CoreShowChannelsComplete extends Model
{
    /**
     * {@inheritdoc}
     */
    public $table = 'ami_log_show_channels_complete';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'list_items',
    ];
}
